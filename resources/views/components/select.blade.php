<!-- resources/views/components/select.blade.php -->
<select {{ $attributes->merge(['class' => 'form-select block mt-1 w-full']) }}>
    {{ $slot }}
</select>
