@push('css')
<style>

  .message-screen{
      display: none;
      position: fixed;
      height: 100%;
      top: 0px;
      bottom: 0px;
      width: 100%;
      color: white;
      z-index: 0;
      font-size: 40px;
      text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
  }

  .message-screen .message {
    position: fixed;
    top: 50%;
  }

  #host-left-lobby{
      background-color: rgba(255, 0, 0, 0.3);
  }

  #saving-screen{
      background-color: rgba(0, 255, 0, 0.3);
  }

</style>
@endpush

<div id="host-left-lobby" class="message-screen">
  <div class="container">
    <div class="row justify-content-center text-center align-items-center">
      <div class="message">
        <p>
            Uh Oh! Looks like the host has left! <br>
            Please wait!
        </p>
      </div>
    </div>
  </div>
</div>

<div id="saving-screen" class="message-screen">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="message">
        <div class='col-12'>
          <div class="spinner-border" role="status"></div>
        </div>

        <p class='col-12 mt-1'>Saving... Please Wait</p>
      </div>
    </div>
  </div>
</div>
