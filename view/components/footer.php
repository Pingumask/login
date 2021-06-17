<footer>Développé par Pingumask &copy;2021-<?=date('Y')?></footer>
<div id="toastError"></div>
<?php if(isset($_SESSION['toastError'])):?>
    <script>
        const TOASTERROR = document.querySelector("#toastError");
        function showToast(text){
            TOASTERROR.innerText=text;
            TOASTERROR.classList.add('show');
            setTimeout(()=>{
                TOASTERROR.classList.remove('show');
            },3500)
        }
        <?php foreach($_SESSION['toastError'] as $num=>$toast):?>
            setTimeout(showToast,<?= $num*4000+200?>,"<?= $toast?>");
        <?php endforeach;
        unset($_SESSION['toastError']);?>
    </script>
<?php endif;?>