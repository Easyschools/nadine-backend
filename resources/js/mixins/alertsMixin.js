export default {
    methods: {
        errorMessages(res) {
            let message = '';
            console.log(res);
            if ('errors' in res) {
                let errors=res.errors;
                for (const [key, error] of Object.entries(errors)) {

                    message +=  key.toUpperCase()+"" + ':- ' + error + '\r\n'+'\r\n'
                }
            }else {
                message='Something went wrong. Please try again later.'
            }
            swal({
                html:true,
                icon: "error",
                title:"Error Messages",
                text:message
            });
        }
    }
}
