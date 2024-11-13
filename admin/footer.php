
  <footer class="footer">
    <p><span class="footer__copyright">&copy;</span> 2024 MTH</p>
    <p>Crafted with <i class="fas fa-heart footer__icon"></i> by <a href="https://www.linkedin.com/in/matt-holland/" target="_blank" class="footer__signature">Hasan Ony</a></p>
  </footer>

  
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var sidebar = document.querySelector('.sidebar');
            var content = document.querySelector('.content');

            sidebar.classList.toggle('active');
            content.classList.toggle('shift');
        });
    </script>
<script>
    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            var parentDropdown = this.parentElement;
            parentDropdown.classList.toggle('active');
        });
    });
</script>


<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("menuDisplayed");
        });
    });

   
</script>

<script>
    document.querySelectorAll('.button').forEach(button => button.addEventListener('click', e => {
    const link = button.closest('a');
    if (link) {
        e.preventDefault();
        button.classList.add('delete');
        setTimeout(() => {
            window.location.href = link.href;
        }, 2400); // Match the duration of the button animation
    }
}));
</script>


<script>
    document.querySelectorAll('.button.update').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default anchor behavior
            const href = this.getAttribute('href'); // Get the href attribute

            // Add the animation class
            this.classList.add('animate');

            // Redirect after animation ends
            setTimeout(() => {
                window.location.href = href;
            }, 400); // Match the duration of the animation
        });
    });
</script>

  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready( function () {
		$('.table').DataTable();
  });
  </script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Sep 28, 2024:
      'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>


</body>
</html>