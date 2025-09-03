 const navLinks = document.querySelectorAll(".nav-list a");
        navLinks.forEach(link => {
          link.addEventListener("click", () => {
            // Remove 'active' from all
            navLinks.forEach(l => l.classList.remove("active"));
            // Add 'active' to clicked one
            link.classList.add("active");
          });
        });