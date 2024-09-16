<form id="recipe-form" action="{{ route('recipes.store')}}" method="POST">
    @csrf
    <input type="text" name="name">
    <button id="send-recipe" type="submit">Submit</button>
</form>
<button id="add-item">Add item</button>

<script>
    const addItem = document.getElementById('add-item');
    addItem.addEventListener('click', () => {
        const div =  document.createElement('div');
        const form = document.getElementById('recipe-form');
        const item = document.createElement('select');
        const foods = @json($foods);
        foods.forEach(element => {
            item.innerHTML += `<option value="${element.id}">${element.item}</option>`;
        });
        item.name = 'item[]';

        const remove = document.createElement('button');
        remove.textContent = 'Remove';
        remove.addEventListener('click', () => {
            div.remove();
        });

        // append before button
        const send = document.getElementById('send-recipe');
        div.appendChild(item);
        div.appendChild(remove);
        form.insertBefore(div, send);
    });
</script>