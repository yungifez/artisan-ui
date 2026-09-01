<?php

namespace Yungifez\AprilUI;

use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;

class AprilComponentTagCompiler extends ComponentTagCompiler
{
    protected function compileSelfClosingTags(string $value)
    {
        $pattern = "/
            <
                \s*
                (?<prefix>x[-\:]|april:)([\w\-\:\.]*)
                \s*
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                @(?:class)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:style)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:if|elseif)\s*\((?:[^()]|\([^()]*\))*\)
                                |
                                @(?:else|endif)\b
                            )
                            |
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                (\:\\\$)(\w+)
                            )
                            |
                            (?:
                                [\w\-:.@%]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        \'[^\']*\'
                                        |
                                        [^\'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
            \/>
        /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            $component = $matches[1] == 'april:' ? 'april::'.$matches[2] : $matches[2];

            return $this->componentString($component, $attributes)."\n@endComponentClass##END-COMPONENT-CLASS##";
        }, $value);
    }

    protected function compileOpeningTags(string $value)
    {
        $pattern = "/
            <
                \s*
                (?<prefix>x[-\:]|april:)([\w\-\:\.]*)
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                @(?:class)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:style)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:if|elseif)\s*\((?:[^()]|\([^()]*\))*\)
                                |
                                @(?:else|endif)\b
                            )
                            |
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                (\:\\\$)(\w+)
                            )
                            |
                            (?:
                                [\w\-:.@%]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        \'[^\']*\'
                                        |
                                        [^\'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
                (?<![\/=\-])
            >
        /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            $component = $matches[1] == 'april:' ? 'april::'.$matches[2] : $matches[2];

            return $this->componentString($component, $attributes);
        }, $value);
    }

    protected function compileClosingTags(string $value)
    {
        return preg_replace("/<\/\s*(?:x[-\:]|april:)[\w\-\:\.]*\s*>/", ' @endComponentClass##END-COMPONENT-CLASS##', $value);
    }

    /**
     * Compile attributes that contain Blade conditionals.
     *
     * Blade directives are valid inside a normal HTML tag, and are commonly
     * used for optional attributes. April tags need to turn their attributes
     * into a component data array before Blade evaluates directives, so keep
     * the condition as part of the generated attribute expression instead.
     *
     * @return array<string, string>
     */
    protected function getAttributesFromAttributeString(string $attributeString)
    {
        if (! preg_match('/@(?:if|elseif|else|endif)\\b/', $attributeString)) {
            return parent::getAttributesFromAttributeString($attributeString);
        }

        $attributes = [];

        foreach ($this->conditionalAttributeSegments($attributeString) as [$segment, $condition]) {
            foreach (parent::getAttributesFromAttributeString($segment) as $attribute => $value) {
                if ($condition !== null) {
                    $value = "({$condition}) ? ({$value}) : null";
                    $this->boundAttributes[$attribute] = true;
                }

                $attributes[$attribute] = $value;
            }
        }

        return $attributes;
    }

    /**
     * Split an attribute string into unconditional and conditional segments.
     *
     * @return list<array{0: string, 1: string|null}>
     */
    protected function conditionalAttributeSegments(string $attributeString): array
    {
        preg_match_all(
            '/@(?<directive>if|elseif|else|endif)\\b(?:\\s*\\((?<condition>(?:[^()]|\\([^()]*\\))*)\\))?/',
            $attributeString,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        $segments = [];
        $stack = [];
        $currentCondition = null;
        $offset = 0;

        foreach ($matches[0] as $index => [$matchedDirective, $directiveOffset]) {
            $directive = $matches['directive'][$index][0];
            $segment = substr($attributeString, $offset, $directiveOffset - $offset);

            if (trim($segment) !== '') {
                $segments[] = [$segment, $currentCondition];
            }

            $condition = $matches['condition'][$index][0] ?? '';

            if ($directive === 'if') {
                $stack[] = [
                    'parent' => $currentCondition,
                    'matched' => $condition,
                ];
                $currentCondition = $this->combineConditions($currentCondition, $condition);
            } elseif ($directive === 'elseif' && $stack !== []) {
                $frameIndex = array_key_last($stack);
                $parent = $stack[$frameIndex]['parent'];
                $matched = $stack[$frameIndex]['matched'];

                $currentCondition = $this->combineConditions(
                    $parent,
                    "!({$matched}) && ({$condition})"
                );
                $stack[$frameIndex]['matched'] = "({$matched}) || ({$condition})";
            } elseif ($directive === 'else' && $stack !== []) {
                $frameIndex = array_key_last($stack);
                $parent = $stack[$frameIndex]['parent'];
                $matched = $stack[$frameIndex]['matched'];

                $currentCondition = $this->combineConditions($parent, "!({$matched})");
                $stack[$frameIndex]['matched'] = 'true';
            } elseif ($directive === 'endif' && $stack !== []) {
                $frame = array_pop($stack);
                $currentCondition = $frame['parent'];
            }

            $offset = $directiveOffset + strlen($matches[0][$index][0]);
        }

        $segment = substr($attributeString, $offset);

        if (trim($segment) !== '') {
            $segments[] = [$segment, $currentCondition];
        }

        return $segments;
    }

    protected function combineConditions(?string $parent, string $condition): string
    {
        return $parent === null ? "({$condition})" : "({$parent}) && ({$condition})";
    }

    public function compileSlots(string $value)
    {
        $pattern = "/
            <
                \s*
                slot
                (?:\:(?<inlineName>\w+(?:-\w+)*))?
                (?:\s+name=(?<name>(\"[^\"]+\"|\\\'[^\\\']+\\\'|[^\s>]+)))?
                (?:\s+\:name=(?<boundName>(\"[^\"]+\"|\\\'[^\\\']+\\\'|[^\s>]+)))?
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                @(?:class)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:style)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                [\w\-:.@]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        \'[^\']*\'
                                        |
                                        [^\'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
                (?<![\/=\-])
            >
        /x";

        $value = preg_replace_callback($pattern, function ($matches) {
            $name = $this->stripQuotes($matches['inlineName'] ?: $matches['name'] ?: $matches['boundName']);

            if (Str::contains($name, '-') && ! empty($matches['inlineName'])) {
                $name = Str::camel($name);
            }

            // If the name was given as a simple string, we will wrap it in quotes as if it was bound for convenience...
            if (! empty($matches['inlineName']) || ! empty($matches['name'])) {
                $name = "'{$name}'";
            }

            $this->boundAttributes = [];

            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            // If an inline name was provided and a name or bound name was *also* provided, we will assume the name should be an attribute...
            if (! empty($matches['inlineName']) && (! empty($matches['name']) || ! empty($matches['boundName']))) {
                $attributes = ! empty($matches['name'])
                    ? array_merge($attributes, $this->getAttributesFromAttributeString('name='.$matches['name']))
                    : array_merge($attributes, $this->getAttributesFromAttributeString(':name='.$matches['boundName']));
            }

            return " @slot({$name}, null, [".$this->attributesToString($attributes).']) ';
        }, $value);

        return preg_replace('/<\/\s*slot[^>]*>/', ' @endslot', $value);
    }
}
