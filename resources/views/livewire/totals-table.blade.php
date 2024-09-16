<div>
    Totals
    <div>
        Calories: {{ round($calories, 2) }}<br>
        Protein: {{ round($protein, 2) }}<br>
        Fat: {{ round($fat, 2) }}<br>
        Carbs: {{ round($carbs, 2) }}
    </div>  
    <table>
        <thead>
            <th>Item</th>
            <th>Amount</th>
            <th>Unit</th>    
            <th>Calories</th>
            <th>Protein</th>
            <th>Fat</th>
            <th>Carbs</th>
        </thead>
        <tbody>
            @foreach($meals as $meal)
                <tr>
                    <td>{{ $meal->item }}</td>
                    <td>{{ round($meal->amount, 2) }}</td>
                    <td>{{ $meal->unit }}</td>
                    <td>{{ round($meal->calories, 2) }}</td>
                    <td>{{ round($meal->protein, 2) }}</td>
                    <td>{{ round($meal->fat, 2) }}</td>
                    <td>{{ round($meal->carbs, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
