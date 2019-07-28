
</main>
<!-- jQuery first, then Bootstrap JS -->
<script src="/offertrak/web-assets/js/jquery-3.4.1.min.js"></script>
<script src="/offertrak/web-assets/js/bootstrap.bundle.min.js"></script>
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
$( document ).ready(function() {
  $(".clickable-row").click(function() {
    window.location = $(this).data("href");
  });
});
</script>
</body>
</html>
