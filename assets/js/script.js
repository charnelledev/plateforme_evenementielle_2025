   setTimeout(() => {
        const successMsg = document.getElementById('successMessage');
        const errorMsg = document.getElementById('errorMessage');
        if (successMsg) successMsg.remove();
        if (errorMsg) errorMsg.remove();
    }, 5000);


    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500); // supprime après transition
        }
    }, 5000);
