   const loginTab = document.getElementById("login-tab");
    const signupTab = document.getElementById("signup-tab");
    const loginForm = document.getElementById("login-form");
    const signupForm = document.getElementById("signup-form");

    // Switch Tabs
    function switchTab(tab) {
      if (tab === "login") {
        loginTab.classList.add("active");
        signupTab.classList.remove("active");
        loginForm.classList.add("active");
        signupForm.classList.remove("active");
      } else {
        signupTab.classList.add("active");
        loginTab.classList.remove("active");
        signupForm.classList.add("active");
        loginForm.classList.remove("active");
      }
    }

    loginTab.addEventListener("click", () => switchTab("login"));
    signupTab.addEventListener("click", () => switchTab("signup"));

    // Basic validation
    function validateLogin(e) {
      e.preventDefault();
      const email = document.getElementById("login-email").value;
      const password = document.getElementById("login-password").value;
      if (email && password) {
        alert("Login successful!");
      }
      return false;
    }

    function validateSignup(e) {
      e.preventDefault();
      const name = document.getElementById("signup-name").value;
      const email = document.getElementById("signup-email").value;
      const password = document.getElementById("signup-password").value;
      if (name && email && password.length >= 6) {
        alert("Signup successful!");
      } else {
        alert("Please fill all fields correctly.");
      }
      return false;
    }