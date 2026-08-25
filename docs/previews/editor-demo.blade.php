<div class="w-full max-w-2xl space-y-6">
    <april:editor name="message" placeholder="Write a message..." />

    <april:editor
        :buttons="['bold', 'italic', 'bullet-list', 'ordered-list', 'undo', 'redo']"
        value="<p>This toolbar uses the array syntax.</p>"
        class="max-w-xl"
    />
</div>
