<html>
    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</head>
    <body>
        <h2>Categories Performance</h2></br>
        <table class="table table-striped" style="margin-left:30px">
    <thead>
            <tr>
                <th scope="col">Category Name</th>
                <th scope="col">No of Products</th>
                <th scope="col">Revenue</th>
                <th scope="col">Revenue Trend</th>
                <th scope="col">Unitsold</th>
                <th scope="col">Unitsold Trend</th>
            </tr> 
    </thead>
    <tbody>
    @foreach($result1 as $productType => $groupedData)
    <tr>
        <td>{{ $productType }}</td>
        {{-- Iterate through each HostingerProduct instance within the group --}}
        @foreach($groupedData as $product)
            <td>{{ $product->orderItemInfo->sum('qty') }}</td>
            <td>{{ $product->orderItemInfo->sum('revenue') }}</td>
            <td>{{ $product->orderItemInfo->sum('no_of_products') }}</td>
        @endforeach
    </tr>
@endforeach
        <!-- @foreach ($result1 as $productType => $groupedItems)
            <tr>
                <td>{{ $productType }}</td>
                <td>{{ $groupedItems->sum('no_of_products') }}</td>
                <td>{{ $groupedItems->sum('revenue') }}</td>
                <td></td>
                <td>{{ $groupedItems->sum('orderItemInfo.qty') }}</td>
                <td></td>
            </tr>
        @endforeach -->
    </tbody>
</table>


    </body>
</html>                       