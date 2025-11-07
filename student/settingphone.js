// ===== PHONE POPUP =====
const openPhoneButton = document.getElementById("openPhoneModal");
const savePhoneButton = document.getElementById("savePhoneBtn");
const closePhonePopup = document.getElementById("closePhonePopup");
const phoneModal = document.getElementById("phoneModal");
const phoneInput = document.getElementById("phoneInput");

openPhoneButton.addEventListener("click", () => {
  phoneModal.classList.add("open");
});

closePhonePopup.addEventListener("click", () => {
  phoneModal.classList.remove("open");
});

savePhoneButton.addEventListener("click", () => {
  const phone = phoneInput.value.trim();
  const phonePattern = /^\+?\d{9,15}$/; // allows + and 9–15 digits

  // Remove any existing message
  const oldMsg = document.querySelector(".phone-msg");
  if (oldMsg) oldMsg.remove();

  // Create new message
  const msg = document.createElement("p");
  msg.classList.add("phone-msg");
  msg.style.fontSize = "14px";
  msg.style.marginTop = "8px";

  if (!phonePattern.test(phone)) {
    msg.textContent = "Please enter a valid phone number (9–15 digits).";
    msg.style.color = "red";
  } else {
    msg.textContent = "Phone number updated successfully!";
    msg.style.color = "green";

    // Close popup after 1s
    setTimeout(() => {
      phoneModal.classList.remove("open");
    }, 1000);
  }

  // Add message below input
  phoneInput.insertAdjacentElement("afterend", msg);
});
