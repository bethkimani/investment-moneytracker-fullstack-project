document.addEventListener("DOMContentLoaded", () => {
    // Contact form
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        contactForm.addEventListener("submit", (e) => {
            e.preventDefault();
            alert("✅ Message sent! We will reply soon.");
            contactForm.reset();
        });
    }
    console.log("✅ Frontend loaded successfully");
});