/**
 * Toggle the visibility of the <div id="email"> element.
 */
function showHideEmail() {
  var el = document.getElementById('email');
  if (!el) return;
  // If currently hidden or not set, display it; otherwise hide it.
  if (el.style.display === 'none' || el.style.display === '') {
    el.style.display = 'block';
  } else {
    el.style.display = 'none';
  }
}
