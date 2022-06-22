const Toast = Swal.mixin( {
    toast      : true,
    position   : 'bottom-right',
    iconColor  : 'white',
    customClass: {
        popup: 'colored-toast',
    },
    timer            : 5000,
    timerProgressBar : true,
    showConfirmButton: false,
    showCloseButton  : true,
    didOpen: ( toast ) => {
        toast.addEventListener( 'mouseenter', Swal.stopTimer )
        toast.addEventListener( 'mouseleave', Swal.resumeTimer )
    },
} );
