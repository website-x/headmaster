<h1 style="text-align:center;">Invoices</h1>

<table>
  <thead>
    <tr>
      <th>Invoice number</th>
      <th>Date</th>
      <th>Name</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>

    @foreach($fees as $data)
    
      <tr>
       
        <td style="width: 150px;text-align:center;">{{$data->id}}</td>
        <td style="width: 150px;text-align:center;">{{$data->last_created_at}}</td>
        <td style="width: 150px;text-align:center;">{{$data->client->full_name}}</td>
        <td style="width: 150px;text-align:center;"> <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$data->amount}}</td>

      </tr>
    @endforeach
  </tbody>
</table>