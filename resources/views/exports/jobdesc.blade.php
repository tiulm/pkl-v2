<table>
    <thead>
        <tr>
            <th>jobname</th>
            <th>deskripsi</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $data)
            <tr>
                <td>{{$data->jobname}}</td>
                <td>{{$data->description}}</td>
                <td>{{$data->status}}</td>
            </tr>
        @endforeach
    </tbody>
</table>