<div>
        <form method="POST" wire:submit="addEntry">
        @csrf
    <div class="type-select">
        <label for="item">
            Item
            <input type="radio" name="type" id="item" value="item" checked wire:model="type"  wire:click="$refresh">
        </label>
        <label for="recipe">
            Recipe
            <input type="radio" name="type" id="recipe" value="recipe" wire:model="type" wire:click="$refresh">
        </label>
    </div>
    @if($type === 'item')

        <label for="food">Food:</label>
        <select name="item" id="item" wire:model="item">
            @foreach($foods as $id => $food)
                <option value="{{ $id }}">{{ $food }}</option>
            @endforeach
        </select>
        @error('food')
            <p>{{ $message }}</p>
        @enderror
        <!-- amount -->
        <label for="amount">Amount:</label>
        <input wire:model="amount" type="text" id="amount" name="amount" value="{{ old('amount') }}">
        @error('amount')
            <p>{{ $message }}</p>
        @enderror
    @else
        <label for="recipe">Recipe:</label>
        <select  name="recipe" id="recipe" wire:model="recipe" wire:change="getRecipe">
            @foreach($recipes as $id => $recipe)
                <option value="{{ $id }}">{{ $recipe }}</option>
            @endforeach
        </select>
        @if ($recipe)

        @foreach ($ingredients as $item_id => $ingredient)
        <div>
            <select value="{{$item_id}}" name="items[{{$loop->index}}]" id="items{{ $item_id }}" wire:model="items.{{ $loop->index }}" >
                @foreach ($foods as $id => $food)
                    <option @if ($item_id == $id) 
                        selected
                    @endif value="{{ $id }}">{{ $food }}</option>
                @endforeach
            </select>
            <input type="text" name="amounts[{{$loop->index}}]" id="amounts{{ $item_id }}" wire:model="amounts.{{$loop->index}}">
        </div>
        @endforeach
            <div>
                <label for="total_weight">Total Weight
                    <input type="text" name="total_weight" id="total_weight" wire:model="total_weight">
                </label>
            </div>
            <div>
                <label for="ate_weight">Ate Weight
                    <input type="text" name="ate_weight" id="ate_weight" wire:model="ate_weight">
                </label>
            </div>
        @endif
        @error('recipe')
            <p>{{ $message }}</p>
        @enderror

    @endif

       <button>Submit</button>
    </form>

    <livewire:totals-table :$todays_meals :key="$todays_meals->pluck('id')->join('-')"/>
</div>
