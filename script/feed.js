if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function show_users_workouts() {
    let feed = document.getElementById("feed");
    $.ajax({
      url: "feed.php",
      type: "post",
      async: false,
      data: {
            'user_workouts': 1
      },
      success: function(response) {
        console.log(response);
        feed.innerHTML = '';
        feed.innerHTML = response;
      }
    })
  }

  // Function to submit a post and update the html to display the new post.
  function post_submit() {
    let feed = document.getElementById("feed");
    let post_text = document.getElementById("review_text").value;
    let workout_count = document.querySelector(".badge-pill");
    $.ajax({
      url: "feed.php",
      type: "post",
      async: false,
      data: {
            'submit_post': 1,
            'post_text': post_text
      },
      success: function(response) {
        // If there is post text and check if on a post/comments screen rather than the feed.
        if (response){
          if (!window.location.href.includes('?')) {
            feed.innerHTML = response + feed.innerHTML;
          }
          workout_count.innerText = parseInt(workout_count.innerText) + 1;
          alert('Log post successfully created!');
        } else {
          alert('You must enter text into the textbox to post!');
        }
      }
    });
    return false;
  }

  function comment_submit() {
    let feed = document.getElementById("feed");
    let post = document.getElementsByClassName("main_post")[0];
    let postId = parseInt(post.id.split('_')[2]);
    let comment_count = document.getElementById(`comment_count_${postId}`);
    let comment = document.querySelector("#comment_text").value;
    $.ajax({
      url: "feed.php",
      type: "post",
      async: false,
      data: {
              'post_id': postId,
              'comment_text': comment,
              'submit_comment': 1
      }, 
      success: function(response) {
        let resp = JSON.parse(response);
        comment_count.innerText = parseInt(comment_count.innerText) + 1;
        resp.forEach(element => feed.innerHTML += element);
      }
    })
    return false;
  }
// Event Listener for clicking on different profiles or 
// buttons or whatever have you. Detects clicks properly,
// but comment part does not work.
document.addEventListener('click', function(e) {
    // Listener for comment bubble interaction
    if(e.target && (/comment_([0-9])+/.test(e.target.id))) {
      let create_comment = document.getElementById("create_comment");
      if (create_comment && create_comment.style.display == "none") {
        create_comment.style.display = "block";
      } else if (create_comment && create_comment.style.display == "block") {
        create_comment.style.display = "none";
      }
    } 
    // Listener for like button interaction.
    else if (e.target && (/like_/.test(e.target.id))) {
        postLike = e.target;
        let postId = parseInt(postLike.id.split('_')[1]);
        let like_count_elem = document.getElementById(`like_count_${postId}`);
        if (postLike.classList.contains("like")) {
          postLike.classList.add("unlike");
          postLike.classList.remove("like");
          like_count_elem.innerText = parseInt(like_count_elem.innerText) + 1;
          $.ajax({
              url: "feed.php",
              type: "post",
              async: false,
              data: {
                  'like': 1,
                  'post_id': postId
              },
              success: function() {
              }
          });
        } else if (postLike.classList.contains("unlike")) {
          postLike.classList.add("like");
          postLike.classList.remove("unlike");
          like_count_elem.innerText = parseInt(like_count_elem.innerText) - 1;
          $.ajax({
              url: "feed.php",
              type: "post",
              async: false,
              data: {
                  'unlike': 1,
                  'post_id': postId
              },
              success: function() {
              }
          });
        }
    } 
    // Listener for delete button interaction.
    else if (e.target && (/delete_([0-9])+/).test(e.target.id)) {
        let confirmation = confirm("Would you like to delete this post?");
        if (confirmation) {
          let postId = parseInt(e.target.id.split('_')[1]);
          let post = e.target.parentNode;
          let feed = document.getElementById("feed");
          $.ajax({
            url: "feed.php",
            type: "post",
            async: false,
            data: {
                'delete': 1,
                'post_id': postId
            },
            success: function() {
              alert("Post successfully deleted!");
              post.remove();
              if (window.location.href.includes('?')) {
                feed.innerHTML = '';
                feed.innerHTML += "<div class='post'><div class='post-body'><p class='post-text'>We're sorry, but you must go <b id='back'>back to the feed page</b>.</p></div></div>";
              }
            }
          });
        }
    }
    // Listener for clicking on a post. 
    else if (e.target && (/post_([0-9])+/.test(e.target.id) || /post_([0-9])/.test(e.target.parentNode.id))) {
        let posts = document.getElementById("feed");
        let postId = parseInt(e.target.id.split('_')[1]) || parseInt(e.target.parentNode.id.split('_')[1]);
        $.ajax({
          url: "feed.php",
          type: "post",
          async: false,
          data: {
              'open_post': 1,
              'post_id': postId
          },
          success: function(response) {
              // If success, parse JSON respone and put it to the screen.
              console.log(response);
              window.history.pushState({additionalInformation: "Viewing a post"}, "FitNation", window.location.href.split('?')[0] + `?post_id=${postId}&open_post=1`);
              posts.innerHTML = '';
              let server_rsp = JSON.parse(response);
              server_rsp.forEach(element => posts.innerHTML += element);
          }
        });
    }
    // Listener for clicking on a back to feed button 
    else if (e.target && e.target.id == "back") {
      let feed = document.getElementById("feed");
      $.ajax({
        url: "feed.php",
        type: "post",
        async: false,
        data: {
          'back': 1
        },
        success: function(response) {
          window.history.pushState({additionalInformation: "Main feed for FitNation"}, "FitNation", window.location.href.split("?")[0]);
          let server_resp = JSON.parse(response);
          feed.innerHTML = '';
          server_resp.forEach(element => feed.innerHTML += element);
        }
      });
    }
  });