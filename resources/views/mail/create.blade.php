<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:19px;line-height:107%;font-family:"Times New Roman",serif;'>Notifikasi Pendaftaran Baru Kelompok PKL-PK Mahasiswa TI FT ULM</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>Proyek dari mahasiswa :</span></p>
<ol style="list-style-type: decimal;">
@foreach ($data->InternshipStudents as $i)
    <li><span style='line-height:107%;font-family:"Times New Roman",serif;font-size:16px;'>{{$i->name}} - {{$i->nim}}</span></li>
@endforeach
</ol>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>Dengan Nama Instansi : <b>{{$data->Agency->agency_name}}</b>.</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>Mohon konfirmasi pendaftaran melalui <a href="http://pkl-ti-ft.ulm.ac.id">pkl-ti-ft.ulm.ac.id.</a></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<p><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>Terimakasih.</span></p>