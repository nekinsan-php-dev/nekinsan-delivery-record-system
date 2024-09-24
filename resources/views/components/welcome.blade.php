<div class="container mx-auto p-4 space-y-4">
    <div class="flex space-x-2">
        <input type="text" wire:model="newValue" placeholder="Enter a value" 
               class="flex-grow px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button wire:click="save" 
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Save
        </button>
    </div>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    ID
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Value
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                        {{ $record->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                        {{ $record->value }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>