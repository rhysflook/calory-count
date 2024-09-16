<div>
    <form action="{{route('foods.store')}}" method="POST">
        @csrf
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="food">Food:</label>
        <input type="text" id="item" name="item" value="{{ old('item') }}">
        @error('food')
            <p>{{ $message }}</p>
        @enderror
        <!-- amount -->
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="{{ old('amount') }}">
        @error('amount')
            <p>{{ $message }}</p>
        @enderror
        <!-- unit -->
        <label for="unit">Unit:</label>
        <input type="text" id="unit" name="unit" value="{{ old('unit') }}">
        @error('unit')
            <p>{{ $message }}</p>
        @enderror
        <!-- calories -->
        <label for="calories">Calories:</label>
        <input type="text" id="calories" name="calories" value="{{ old('calories') }}">
        @error('calories')
            <p>{{ $message }}</p>
        @enderror
        <!-- protein -->
        <label for="protein">Protein:</label>
        <input type="text" id="protein" name="protein" value="{{ old('protein') }}">
        @error('protein')
            <p>{{ $message }}</p>
        @enderror
        <!-- fat -->
        <label for="fat">Fat:</label>
        <input type="text" id="fat" name="fat" value="{{ old('fat') }}">
        @error('fat')
            <p>{{ $message }}</p>
        @enderror
        <!-- carbs -->
        <label for="carbs">Carbs:</label>
        <input type="text" id="carbs" name="carbs" value="{{ old('carbs') }}">
        @error('carbs')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">Submit</button>
    </form>
</div>