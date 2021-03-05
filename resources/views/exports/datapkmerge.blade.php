<table>
    <thead>
        <tr>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Tempat</th>
            <th>Judul</th>
            <th>Anggota 1</th>
            <th>Nim Anggota 1</th>
            <th>Role</th>
            <th>Anggota 2</th>
            <th>Nim Anggota 2</th>
            <th>Role</th>
            <th>Anggota 3</th>
            <th>Nim Anggota 3</th>
            <th>Role</th>
            <th>Anggota 4</th>
            <th>Nim Anggota 4</th>
            <th>Role</th>
            <th>Ketua Pembahas</th>
            <th>NIP Ketua Pembahas</th>
            <th>Pembahas 1</th>
            <th>NIP Pembahas 1</th>
            <th>Pembahas 2</th>
            <th>NIP Pembahas 2</th>
            <th>Pembahas 3</th>
            <th>NIP Pembahas 3</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $data)
            <tr>
                <td>{{$data->GroupProjectSchedule->day}}</td>
                <td>{{$data->GroupProjectSchedule->tanggal}}</td>
                <td>{{ Carbon\Carbon::parse($data->GroupProjectSchedule->time)->format('H.i') . " - " . Carbon\Carbon::parse($data->GroupProjectSchedule->time_end)->format('H.i') . ""}}</td>
                <td>{{$data->GroupProjectSchedule->place}}</td>
                <td>{{$data->title}}</td>
                    @if(count($data->InternshipStudents) <= 3)
                        @php
                            $data->InternshipStudents->push(5);
                        @endphp
                    @endif
                @foreach($data->InternshipStudents as $key=>$agt)
                    @if($key === 3 && $agt === 5)
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                    @else
                        <td>{{$agt->name}}</td>
                        <td data-format="0">{{$agt->nim}}</td>
                        <td>
                            @foreach($agt->Jobdescs as $role)
                                <p>{{$role->jobname}}/</p>
                            @endforeach
                    </td>
                    @endif
                @endforeach
                @foreach($data->GroupProjectExaminer as $penguji)
                    <td>{{$penguji->Lecturer->name}}</td>
                    <td data-format="0">{{$penguji->Lecturer->NIP}}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>