<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 bg-iqrain-pink text-white hover:bg-iqrain-pink/80 whitespace-nowrap rounded cursor-pointer']) }}>
    {{ $slot }}
</button>