    </div>
    <script>
      // Simple mobile nav toggle
      const navToggle = document.getElementById('navToggle');
      const mobileNav = document.getElementById('mobileNav');
      if (navToggle && mobileNav) {
        navToggle.addEventListener('click', () => {
          mobileNav.classList.toggle('hidden');
        });
      }
    </script>
    <script src="/hospital-system/js/scripts.js"></script>
  </body>
</html>

