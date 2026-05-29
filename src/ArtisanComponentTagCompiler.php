<?php

namespace Yungifez\ArtisanUI;

use Illuminate\View\Compilers\ComponentTagCompiler;

class ArtisanComponentTagCompiler extends ComponentTagCompiler
{

    protected function compileSelfClosingTags(string $value)
    {
        $pattern = "/
            <
                \s*
                (?<prefix>x[-\:]|aui:)([\w\-\:\.]*)
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

            $component = $matches[1] == "aui:" ? "aui::".$matches[2] : $matches[2];

            return $this->componentString($component, $attributes) . "\n@endComponentClass##END-COMPONENT-CLASS##";
        }, $value);
    }

    protected function compileOpeningTags(string $value)
    {
        $pattern = "/
            <
                \s*
                (?<prefix>x[-\:]|aui:)([\w\-\:\.]*)
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

            $component = $matches[1] == "aui:" ? "aui::".$matches[2] : $matches[2];

            return $this->componentString($component, $attributes);
        }, $value);
    }

    protected function compileClosingTags(string $value)
    {
        return preg_replace("/<\/\s*(?:x[-\:]|aui:)[\w\-\:\.]*\s*>/", ' @endComponentClass##END-COMPONENT-CLASS##', $value);
    }
}
