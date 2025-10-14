@props([
    'striped' => true, // optional striped rows
])

<div class="w-full overflow-x-auto rounded" >
    <table class="min-w-[600px] md:min-w-full divide-y divide-gray-200 ">
        <thead class="bg-gray-50">
            {{ $thead }}
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{ $tbody }}
        </tbody>
    </table>
</div>

@if($striped)
    <style>
        tbody tr:nth-child(odd) {
            background-color: #f9fafb; /* Tailwind gray-50 */
        }
    </style>
@endif
