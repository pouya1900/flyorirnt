<div id="main_login" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" {{\Illuminate\Support\Facades\Route::currentRouteName()=="passengers_info" ? "data-backdrop=static data-keyboard=false" : ""}}  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            @include('front.partials.login_form')

            <div class="container">
                <div class="guest_section row justify-content-md-center">

                    <div class="col-lg-7 guest_section_content">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('trs.continue_as_guest')</button>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

