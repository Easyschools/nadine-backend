<table>
    <thead>
        <tr>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">id
            </th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                name_ar
            </th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                name_en
            </th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                description_ar</th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                description_en</th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">price
            </th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                price_after_discount</th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">sku
            </th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                collection</th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                material</th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                tag
            </th>
            <th style="color: black; font-size: 16px; text-align:center;font-weight: bold;border: 1px solid black;">
                variants: color(name_en, name_ar, image), dimension
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td style="text-align: center; width:50px; vertical-align: top; border: 1px solid black;">
                    {{ $product->id }}</td>
                <td style="text-align: center; width:150px; vertical-align: top; border: 1px solid black;">
                    {{ $product->name_ar }}</td>
                <td style="text-align: center; width:150px; vertical-align: top; border: 1px solid black;">
                    {{ $product->name_en }}</td>
                <td style="text-align: center; width:200px; vertical-align: top; border: 1px solid black;">
                    {{ $product->description_ar }}</td>
                <td style="text-align: center; width:200px; vertical-align: top; border: 1px solid black;">
                    {{ $product->description_en }}</td>
                <td style="text-align: center; width:100px; vertical-align: top; border: 1px solid black;">
                    {{ $product->price }}</td>
                <td style="text-align: center; width:200px; vertical-align: top; border: 1px solid black;">
                    {{ $product->price_after_discount }}</td>
                <td style="text-align: center; width:100px; vertical-align: top; border: 1px solid black;">
                    {{ $product->sku }}</td>
                <td style="text-align: center; width:150px; vertical-align: top; border: 1px solid black;">
                    {{ $product->collection?->name_en }}</td>
                <td style="text-align: center; width:150px; vertical-align: top; border: 1px solid black;">
                    {{ $product->material?->name_en }}</td>
                <td style="text-align: center; width:150px; vertical-align: top; border: 1px solid black;">
                    {{ $product->tag?->name_en }}</td>
                @foreach ($product->variants as $variant)
                    <td style="text-align: center; width:1060px; vertical-align: top; border: 1px solid black;">
                        {{ $variant?->color?->name_en }}, {{ $variant?->color?->name_ar }}, {{ $variant?->color?->image }},
                        {{ $variant?->additional_price }}, {{ $variant?->dimension->dimension }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
