{{-- resources/views/partials/sms_login_modal.blade.php --}}
<div class="modal fade" id="smsLoginModal" tabindex="-1" role="dialog" aria-labelledby="smsLoginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="smsLoginModalLabel" class="modal-title">Customer Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="modal_sms_form" method="POST" action="{{ route('customer.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="modal_name">Name</label>
                        <input type="text" id="modal_name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group" id="modal_phone_group">
                        <label for="modal_phone">Mobile Number</label>
                        <input type="tel" id="modal_phone" name="input_name" class="form-control" maxlength="10"
                            required>
                        <small id="modal_phone_error" class="text-danger"></small>
                    </div>
                    <div class="form-group" id="modal_otp_group" style="display:none;">
                        <label for="modal_otp">Enter OTP</label>
                        <input type="text" id="modal_otp" name="check_otp" class="form-control" maxlength="4" required>
                        <small id="modal_otp_error" class="text-danger"></small>
                    </div>
                    <button type="button" id="modal_send_otp" class="btn btn-primary btn-block">Send OTP</button>
                    <button type="button" id="modal_verify_otp" class="btn btn-success btn-block"
                        style="display:none;">Verify & Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>