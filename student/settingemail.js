const openButton = document.getElementById("openModal");
const closeButton = document.getElementById("closeModal");
const closePopup = document.getElementById("closePopup");
const modal = document.getElementById("modal");
const input = document.getElementById("popupInput");

openButton.addEventListener("click", () => {
  modal.classList.add("open");
});

closePopup.addEventListener("click", () => {
  modal.classList.remove("open");
});

closeButton.addEventListener("click", () => {
  const email = input.value.trim();
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Remove any existing message
  const oldMsg = document.querySelector(".email-msg");
  if (oldMsg) oldMsg.remove();

  // Create a new message
  const msg = document.createElement("p");
  msg.classList.add("email-msg");
  msg.style.fontSize = "14px";
  msg.style.marginTop = "8px";

  if (!emailPattern.test(email)) {
    msg.textContent = "Please enter a valid email address.";
    msg.style.color = "red";
    input.insertAdjacentElement("afterend", msg);
  } else {
    msg.textContent = "Email updated successfully!";
    msg.style.color = "green";
    input.insertAdjacentElement("afterend", msg);

    // Close popup after short delay (e.g. 1 second)
    setTimeout(() => {
      modal.classList.remove("open");
    }, 1000);
  }
});
