var weight = Number(document.getElementById("weight").innerText.trim()) * 0.45359237;
var height = Number(document.getElementById("height").innerText.trim()) * 2.54;
var age = document.getElementById("age").innerText.trim();


function createPersonalData(header, data) {
    let li = document.createElement("li");
    let classes = "list-group-item d-flex justify-content-between align-items-center flex-wrap".split(' ');
    li.classList.add(...classes);

    let h6 = document.createElement("h6");
    h6.classList.add("mb-0");
    h6.innerText = header;

    let span = document.createElement("span");
    span.innerText = data
        
    li.appendChild(h6)
    li.appendChild(span)
    console.log(li)
    return li
}

async function bmi(weight, height, age) {
  const url = 'https://fitness-calculator.p.rapidapi.com/bmi?age='+age+'&weight='+weight+'&height='+height;
  const options = {
    method: 'GET',
    headers: {
      'X-RapidAPI-Key': '87b9f2b24dmsh19936e7fdd96710p1d89c2jsn9dd293a65f60',
      'X-RapidAPI-Host': 'fitness-calculator.p.rapidapi.com'
    }
  };
  try {
      let response = await fetch(url, options);

      response = await response.json();
      return response;
      // console.log(response);
  } catch (error) {
      console.error(error);
  }
}

 pd_list =document.getElementById("pd_list");
 if (pd_list != null) { 
   bmi(weight, height, age).then((val) => {
     console.log(val)
     if (val.status_code/100 == 2) {
       pd_list.appendChild(createPersonalData("bmi", val.data["bmi"]));
       pd_list.appendChild(createPersonalData("Ideal bmi range", val.data["healthy_bmi_range"]))
       pd_list.appendChild(createPersonalData("health", val.data["health"]));
     } else {
       val.errors.forEach(error => {
         var li = document.createElement("li");
         let classes = "list-group-item d-flex justify-content-between align-items-center flex-wrap".split(' ');
         li.classList.add(...classes);
         if (error == "height must be between 130 cm to 230 cm. ") {
           li.innerText = "In order to see bmi data, your height must be between 51 in and 90 in."
         } else if (error == "weight must be between 40 kg to 160 kg. ") {
           li.innerText = "In order to see bmi data, your weight must be between 89 lbs and 352 lbs."
         } else {
           li.innerText = "In order to see bmi data, your "+error
         }
         pd_list.appendChild(li)
       });
     }

    });
}

      // user on like
      $(document).ready(function() {
        $('.liker').click(function(){
          var postid = $(this).attr('id');
          if ($(this).hasClass("like")) {
            $(this).addClass("unlike");
            $(this).removeClass("like");
            id = "like-count-for-"+$(this).attr('id');
            like_count_elem = document.getElementById(id)
            like_count_elem.innerText = parseInt(like_count_elem.innerText) + 1
            $.ajax({
              url: 'user.php',
              type: 'post',
              async: false,
              data: {
                'liked':1,
                'postid': postid
              },
              success:function(){
              }
            })
          } else {
            $(this).addClass("like");
            $(this).removeClass("unlike");
            id = "like-count-for-"+$(this).attr('id');
            like_count_elem = document.getElementById(id)
            like_count_elem.innerText = parseInt(like_count_elem.innerText) - 1
            $.ajax({
              url: 'user.php',
              type: 'post',
              async: false,
              data: {
                'unliked':1,
                'postid': postid
              },
              success:function(){

              }
            })
          }
        })

        
      });