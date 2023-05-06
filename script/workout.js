import getKey from './script/help.js';
var abdominals,
  biceps,
  calves,
  chest,
  forearms,
  glutes,
  hamstrings,
  lats,
  lowerBack,
  middleBack,
  neck,
  quadriceps,
  traps,
  triceps;
var exercise;
// abs workout
async function getAbs() {
  abdominals = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "abdominals",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await abdominals.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// biceps workout
async function getBiceps() {
  biceps = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "biceps",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await biceps.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// calves workout
async function getCalves() {
  calves = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=calves",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await calves.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// chest workout
async function getChest() {
  chest = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "chest",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await chest.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// forearms workout
async function getForearms() {
  forearms = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "forearms",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await forearms.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// glutes workout
async function getGlutes() {
  glutes = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=glutes",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await glutes.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// hamstrings workout
async function getHamstrings() {
  hamstrings = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "hamstrings",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await hamstrings.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// lats workout
async function getLats() {
  lats = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "lats",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await lats.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// lower back workout
async function getLowerBack() {
  lowerBack = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=lower_back",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await lowerBack.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// middle back workout
async function getMiddleBack() {
  middleBack = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=middle_back",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await middleBack.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}
// quadriceps workout
async function getQuadriceps() {
  quadriceps = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "quadriceps",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  document.getElementById("workouts").innerHTML = "";
  var temp = await quadriceps.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

// traps workout
async function getTraps() {
  traps = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "traps",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  document.getElementById("workouts").innerHTML = "";
  var temp = await traps.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}
// triceps workout
async function getTriceps() {
  triceps = await fetch(
    "https://api.api-ninjas.com/v1/exercises?muscle=" + "triceps",
    {
      method: "GET",
      headers: { "X-Api-Key": getKey() },
      contentType: "application/json",
    }
  );
  var temp = await triceps.json();
  for (var i = 0; i < temp.length; i++) { 
    exercise = `
    <div class="card">
      <div class="card-header">
      ${temp[i].name}
      </div>
    <div class="card-body">
      <h5 class="card-title">${temp[i].equipment} - ${temp[i].difficulty}</h5>
      <p class="card-text">${temp[i].instructions}</p>
    </div>
    </div>
    <br>`;
     document.getElementById("workouts").innerHTML += exercise;
  } 
}

//now listeners for diff buttons
document.getElementById("abdominals").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getAbs();
});
document.getElementById("biceps").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getBiceps();
});
document.getElementById("calves").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getCalves();
});
document.getElementById("chest").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getChest();
});
document.getElementById("forearms").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getForearms();
});
document.getElementById("glutes").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getGlutes();
});
document.getElementById("lats").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getLats();
});
document.getElementById("hamstrings").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getHamstrings();
});
document.getElementById("lowerback").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getLowerBack();
});
document.getElementById("middleback").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getMiddleBack();
});
document.getElementById("quadriceps").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getQuadriceps();
});
document.getElementById("triceps").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getTriceps();
});
document.getElementById("traps").addEventListener("click", e => {
  document.getElementById("workouts").innerHTML = "";
  getTraps();
});

