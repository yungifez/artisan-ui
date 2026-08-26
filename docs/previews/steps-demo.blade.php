@php
    $steps = [
        [
            'value' => 1,
            'label' => 'Account',
            'description' => 'Create your account',
            'href' => '#account',
        ],
        [
            'value' => 2,
            'label' => 'Profile',
            'description' => 'Add your details',
        ],
        [
            'value' => 3,
            'label' => 'Preferences',
            'description' => 'Choose your settings',
        ],
        [
            'value' => 4,
            'label' => 'Review',
            'description' => 'Confirm your choices',
        ],
    ];
@endphp

<div class="space-y-12">
    <div class="space-y-4">
        <div>
            <p class="text-sm font-medium">Create your profile</p>
            <p class="text-sm text-muted-foreground">Follow the steps to finish setup.</p>
        </div>

        <april:steps :items="$steps" current="2" />
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
        <april:card>
            <slot:title>Profile details</slot:title>
            <slot:description>Complete the active step.</slot:description>
            <slot:content class="space-y-4">
                <div class="space-y-2">
                    <april:label for="steps-name">Display name</april:label>
                    <april:input id="steps-name" value="Alex Morgan" />
                </div>
                <div class="space-y-2">
                    <april:label for="steps-role">Role</april:label>
                    <april:input id="steps-role" value="Product designer" />
                </div>
            </slot:content>
            <slot:footer class="justify-between">
                <april:button variant="outline">Back</april:button>
                <april:button>Continue</april:button>
            </slot:footer>
        </april:card>

        <div class="rounded-lg border bg-card p-6">
            <p class="mb-6 text-sm font-medium">Vertical layout</p>
            <april:steps orientation="vertical" :items="$steps" current="2" />
        </div>
    </div>
</div>
