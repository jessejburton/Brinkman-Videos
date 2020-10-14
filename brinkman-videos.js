function whichTransitionEvent() {
  var t;
  var el = document.createElement('fakeelement');
  var transitions = {
    'transition': 'transitionend',
    'OTransition': 'oTransitionEnd',
    'MozTransition': 'transitionend',
    'WebkitTransition': 'webkitTransitionEnd'
  }

  for (t in transitions) {
    if (el.style[t] !== undefined) {
      return transitions[t];
    }
  }
}

/* Listen for a transition! */
var transitionEvent = whichTransitionEvent();

if (document.querySelector(".brinkman-comments")) {
  const brinkman_comments = document.querySelectorAll(".comment");

  showNextComment();

  function showNextComment() {

    // Get the current comment
    let current_comment = document.querySelector(".comment.show");
    if (!current_comment) {
      current_comment = brinkman_comments[0];
    }

    // Get the next comment
    let next_comment = current_comment.nextElementSibling;
    if (!next_comment) {
      next_comment = brinkman_comments[0];
    }

    current_comment.classList.remove("show");
    next_comment.classList.add("show");

    setTimeout(showNextComment, 7000);
  }

}