<div class="grid gap-8 lg:grid-cols-2">
    <div class="space-y-3">
        <p class="text-sm font-medium">Horizontal, looping</p>
        <april:carousel class="mx-auto w-full max-w-md rounded-lg border p-2">
            <april:carousel-item>
                <div class="flex aspect-video items-center justify-center rounded-md bg-primary p-6 text-2xl font-semibold text-primary-foreground">First slide</div>
            </april:carousel-item>
            <april:carousel-item>
                <div class="flex aspect-video items-center justify-center rounded-md bg-secondary p-6 text-2xl font-semibold text-secondary-foreground">Second slide</div>
            </april:carousel-item>
            <april:carousel-item>
                <div class="flex aspect-video items-center justify-center rounded-md bg-muted p-6 text-2xl font-semibold">Third slide</div>
            </april:carousel-item>
        </april:carousel>
    </div>

    <div class="space-y-3">
        <p class="text-sm font-medium">Vertical, bounded</p>
        <april:carousel orientation="vertical" :loop="false" class="mx-auto h-64 w-full max-w-md rounded-lg border p-2">
            <april:carousel-item>
                <div class="flex h-60 items-center justify-center rounded-md bg-muted p-6 text-lg font-semibold">Top</div>
            </april:carousel-item>
            <april:carousel-item>
                <div class="flex h-60 items-center justify-center rounded-md bg-secondary p-6 text-lg font-semibold text-secondary-foreground">Middle</div>
            </april:carousel-item>
            <april:carousel-item>
                <div class="flex h-60 items-center justify-center rounded-md bg-primary p-6 text-lg font-semibold text-primary-foreground">Bottom</div>
            </april:carousel-item>
        </april:carousel>
    </div>
</div>
