
 <div class="container">
 

    <div class="grid-margin card">
        <div class="card-body">
            @if (Auth::User()->approvalStatus == 'DECLINED')
                
                <h3>Akun Anda Belum Memenuhi Persyaratan</h3><br>
                <!-- <h3></h3><br> -->
                <h3>Note :</h3><h5>
                @php 
                    $comment = Auth::User()->decisionList;
                    echo end($comment)['changeRemarks'] 
                @endphp
                </h5><br><br>
                <a class="btn btn-primary" href="/profile-edit" role="button">< Back</a>
            @else
                <h3>Maaf, Anda Tidak Bisa Membuat Kampanye</h3><br>
                <h3>Akun Anda Belum Terverifikasi</h3><br><br>
                <a class="btn btn-primary" href="/ecf/dashboard" role="button">< Back</a>
            @endif
        </div>
    </div>
</div>