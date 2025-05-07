<table class="table table-bordered align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th>Category Name</th>
            <th>Product Comission </th>
            <th>Service Comission </th>
        </tr>
    </thead>
    <tbody>
        @foreach($business_categories as $key=>$business_category)
        <tr>
            <td><input type="hidden" name="business_category[]" value="{{$business_category->id}}" />{{$business_category->name}}</td>
            <td><input type="number" class="form-control" name="product_comission_percentage[]" min="{{$business_category->product_min_comission}}" step="any"   required /> ({{$business_category->product_min_comission_type }})</td>
            <td><input type="number" class="form-control" name="service_comission_percentage[]" min="{{$business_category->service_min_comission}}" step="any"  required /> ({{$business_category->service_min_comission_type }})</td>
            <input type="hidden" name="business_category_product_balance[]" value="0" />
            <input type="hidden" name="business_category_service_balance[]" value="0" />
            <input type="hidden" name="product_type_comission[]" value="{{$business_category->product_min_comission_type }}" />
            <input type="hidden" name="service_type_comission[]" value="{{$business_category->service_min_comission_type }}" />
        </tr>
        @endforeach
    </tbody>
</table>
