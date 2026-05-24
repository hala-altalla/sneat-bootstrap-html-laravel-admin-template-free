importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');


firebase.initializeApp({
  apiKey: "AIzaSyDUCR3ys3mjdSK7xlIjptAtG4xyhiHnG6Q",
  authDomain: "notifications-system-bdf44.firebaseapp.com",
  projectId: "notifications-system-bdf44",
  storageBucket: "notifications-system-bdf44.firebasestorage.app",
  messagingSenderId: "579849444245",
  appId: "1:579849444245:web:b6c020ecdd56bb43df349c"
});


const messaging = firebase.messaging();


messaging.onBackgroundMessage(payload => {
    self.registration.showNotification(payload.notification.title, {
      body: payload.notification.body,
      icon: '/logo.png'
    });
});
