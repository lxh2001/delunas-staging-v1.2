// Show loading overlay
function showLoadingOverlay() {
  document.getElementById("loading-overlay").style.display = "block";
}

// Hide loading overlay
function hideLoadingOverlay() {
  document.getElementById("loading-overlay").style.display = "none";
}

// Function to trigger the loading effect when the page is loading
function pageLoading() {
  showLoadingOverlay();
}

// Function to hide the loading overlay when the page has finished loading
function pageLoaded() {
  hideLoadingOverlay();
}

// Attach the loading effect to the page loading event
window.addEventListener("beforeunload", pageLoading);
window.addEventListener("load", pageLoaded);