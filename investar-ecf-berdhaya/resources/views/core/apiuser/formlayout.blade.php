<div class="row">
    <div class="col-12">
        @if(!$_isCreate)
            <b-tabs content-class="mt-3 tabHeader" nav-class="tab-header" fill justified >
                <b-tab title="Login Info" active>
        @endif
                    {!! $name !!}
                    {!! $description !!}
                    {!! $email !!}
                    {!! $username !!}
                    {!! $mobile !!}
                    <hr>
                    {!! $password !!}
                    {!! $confirm_password !!}
        @if(!$_isCreate)
                </b-tab>
                <b-tab title="API Token">
                    <button class="btn btn-primary" style="width:100%;" @click="getToken()" >Re-generate Token</button>
                    <hr>
                    {!! $token !!}
                </b-tab>
            </b-tabs>
        @endif

    </div>
</div>
