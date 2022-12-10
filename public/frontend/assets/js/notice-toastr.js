
// Auto Toasts
Livewire.on('notice', notice => {
    //-> Defaults
    var sticky = notice.sticky ?? false,
        timeout = notice.timeout ?? 4000
        position = notice.position ?? 'bottom-right'
        progressBar = notice.progressBar ?? true;
    //-> Trigger
    // setTimeout( () => {

                toastr[notice.type](
                    notice.message,
                    notice.heading ?? notice.type,
                    {
                        closeButton: notice.close ?? true,
                        tapToDismiss: notice.tapToDismiss ?? false,
                        rtl: notice.rtl ?? false,
                        positionClass: "toast-"+position,
                        progressBar: (sticky === true) ? false : progressBar,
                        timeOut: (sticky === true) ? 0 : timeout,
                    }
                );

        // }, 1000);
});
