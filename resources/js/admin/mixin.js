export const mixin = {
    methods: {

        successToastReloadPage(message) {
            const Toast = swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener("mouseenter", swal.stopTimer);
                        toast.addEventListener("mouseleave", swal.resumeTimer);
                    },
                },
                function() {}
            );

            Toast.fire({
                icon: "success",
                title: message,
            }).then(function() {

                window.location.reload();
            });

        },
        //successtoast message with redirect


        successToastRedirect(message, link) {
            const Toast = swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener("mouseenter", swal.stopTimer);
                        toast.addEventListener("mouseleave", swal.resumeTimer);
                    },
                },
                function() {}
            );

            Toast.fire({
                icon: "success",
                title: message,
            }).then(function() {

                window.location.replace(link);
            });

        },
    }
}