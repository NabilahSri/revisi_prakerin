import "./bootstrap";
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyCCSnGfpTe4NRUkLMcgDwfdzPG9PZ_vDFM",
    authDomain: "jurnal-prakerin.firebaseapp.com",
    projectId: "jurnal-prakerin",
    storageBucket: "jurnal-prakerin.appspot.com",
    messagingSenderId: "818058500283",
    appId: "1:818058500283:web:10a23ad5f49c97224df19e",
    measurementId: "G-VCWPWV7LT6",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const messaging = getMessaging(app);

onMessage(messaging, (payload) => {
    console.log("Message received. ", payload);
    alert("Ada notifikasi baru");
});

getToken(messaging, {
    vapidKey:
        "BBLpQW1JCOvvtCDz2Z-cw2B8pFp06OoRtj-Fj4mt_-0xQ7xHDlDik0VHZ55HbQrEm0dRB1NjCXyPNKJ1S7HzxJw",
})
    .then((currentToken) => {
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            console.log(currentToken);
            sentTokenToServer(currentToken);
        } else {
            // Show permission request UI
            requestPermission();
            console.log(
                "No registration token available. Request permission to generate one."
            );
            // ...
        }
    })
    .catch((err) => {
        console.log("An error occurred while retrieving token. ", err);
        // ...
    });

function sentTokenToServer(token) {
    var csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let formData = new FormData();
    formData.append("web_token", token);
    fetch("/web-token", {
        headers: {
            "X-CSRF-Token": csrf,
            _method: "_POST",
        },
        method: "post",
        credentials: "same-origin",
        body: formData,
    }).then((response) => {
        console.log(response.status);
    });
}

function requestPermission() {
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("Notification permission granted.");
            // TODO(developer): Retrieve a registration token for use with FCM.
            // ...
        } else {
            console.log("Unable to get permission to notify.");
            alert(
                "Silahkan izinkan notifikasi untuk mendapatkan notifikasi terbaru"
            );
        }
    });
}
