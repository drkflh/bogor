<div class="row">
    <div class="col-12">
        <b-tabs content-class="mt-3 tabHeader" nav-class="tab-header" fill justified >
            <b-tab title="Login Info" active>
                {!! $name !!}
                {!! $description !!}
                {!! $email !!}
                {!! $username !!}
                {!! $mobile !!}
            </b-tab>
            <b-tab title="API Token">
                <button class="btn btn-primary" style="width:100%;" @click="getToken()" >Re-generate Token</button>
                <hr>
                {!! $token !!}
            </b-tab>
        </b-tabs>
    </div>
</div>
