<div class="grid gap-6 lg:grid-cols-2">
    <april:chart label="Weekly activity">
        <slot:header>
            <h3 class="font-semibold">Weekly activity</h3>
            <p class="text-sm text-muted-foreground">Messages sent over the last week.</p>
        </slot:header>
        <april:chart-bar label="Mon" value="42" />
        <april:chart-bar label="Tue" value="68" color="bg-blue-500" />
        <april:chart-bar label="Wed" value="54" color="bg-violet-500" />
        <april:chart-bar label="Thu" value="86" color="bg-emerald-500" />
        <april:chart-bar label="Fri" value="72" color="bg-amber-500" />
    </april:chart>

    <april:chart label="Quarterly progress" class="bg-muted/30">
        <slot:header>
            <h3 class="font-semibold">Quarterly progress</h3>
            <p class="text-sm text-muted-foreground">A custom maximum of 1,000.</p>
        </slot:header>
        <april:chart-bar label="Q1" value="620" max="1000" color="bg-primary" />
        <april:chart-bar label="Q2" value="780" max="1000" color="bg-primary" />
        <april:chart-bar label="Q3" value="910" max="1000" color="bg-primary" />
        <april:chart-bar label="Q4" value="740" max="1000" color="bg-primary" />
    </april:chart>
</div>
