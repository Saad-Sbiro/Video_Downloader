
  const input = document.getElementById("urlInput");
  const buttons = document.querySelectorAll(".btnn");
  const platformInput = document.getElementById("platformInput");
  const select = document.getElementById("quality");

  if (!select.dataset.originalOptions) {
    select.dataset.originalOptions = select.innerHTML;
  }

  buttons.forEach(button => {
    button.addEventListener("click", () => {
      const newPlaceholder = button.getAttribute("data-placeholder");
      input.placeholder = newPlaceholder;

      if (button.textContent.includes("Facebook")) {
        platformInput.value = "facebook";
        updateQualityOptions("facebook");
      } else if (button.textContent.includes("Instagram")) {
        platformInput.value = "instagram";
        updateQualityOptions("instagram");
      } else {
        platformInput.value = "youtube";
        updateQualityOptions("youtube");
      }

      buttons.forEach(btn => btn.classList.remove("clicked"));
      button.classList.add("clicked");
    });
  });

  function updateQualityOptions(platform) {
    select.innerHTML = select.dataset.originalOptions;

    let allowed = [];

    if (platform === "instagram") {
      allowed = ["bestaudio", "137+140"];
    } else if (platform === "facebook") {
      allowed = ["bestaudio", "137+140"];
    } else {

      return;
    }

    Array.from(select.options).forEach(option => {
      if (!allowed.includes(option.value)) {
        option.remove();
      }
    });
  }

  document.querySelector("form").addEventListener("submit", function () {
    document.getElementById("progressBox").style.display = "block";
    let percent = 0;
    let bar = document.getElementById("fakeBar");
    let txt = document.getElementById("fakePercent");

    let interval = setInterval(() => {
      if (percent < 98) {
        percent += Math.random() * 2;
        bar.style.width = percent + "%";
        txt.innerText = Math.floor(percent) + "%";
      }
    }, 300);
  });

  function closeNotification() {
    document.getElementById("notification").style.display = "none";
  }
