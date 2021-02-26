export default {
    authUser(){
        let user = JSON.parse(localStorage.getItem('user'));
        if (user) {
            return user;
        } else {
            return null;
        }
    },

    authToken(){
        let user = JSON.parse(localStorage.getItem('user'));
        if (user && user.accessToken) {
            return user.accessToken;
        } else {
            return null;
        }
    },

    authHeader() {
        let user = JSON.parse(localStorage.getItem('user'));
        if (user && user.accessToken) {
            return { Authorization: 'Bearer ' + user.accessToken };
        } else {
            return null;
        }
    }
}