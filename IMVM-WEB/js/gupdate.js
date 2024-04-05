  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyAgUSDeqZ1C-JpFpEHTPTvoKgVmOzRZ10I",
    authDomain: "imvmbot-api.firebaseapp.com",
    projectId: "imvmbot-api",
    storageBucket: "imvmbot-api.appspot.com",
    messagingSenderId: "93578644004",
    appId: "1:93578644004:web:35056d9b3048ca4a6e26b1",
    measurementId: "G-76PKXHS15T"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);