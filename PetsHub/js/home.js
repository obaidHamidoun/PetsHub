// Function to check if the user has a cookie indicating they are logged in
function checkLoginCookie() {
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'user_id' && value) {
            return true; // User is logged in
        }
    }
    return false; // User is not logged in
}

if (!checkLoginCookie()) {
    window.location.href = '../html/index.html';
} else {
    const menuButton = document.querySelector('.menuButton');
    const nav = document.querySelector('nav');
    const closeButton = document.querySelector('.closeButton');
    const pages = document.querySelectorAll('.page');
    const PagesIcons = document.querySelectorAll('.PageIcon');

    menuButton.addEventListener('click', function() {
        nav.style.animation = 'slide 1s cubic-bezier(0.85, 0, 0.15, 1) forwards';
    });

    closeButton.addEventListener('click', function() {
        nav.style.animation = 'Backslide 1s cubic-bezier(0.85, 0, 0.15, 1) forwards';
    });


    function updateInfoContent() {
        const infoElement = document.querySelector('.InfoDC');
        if (window.innerWidth <= 800) {
            infoElement.innerHTML = 'PetsHub’s Daycare provides reliable and high-quality pet care, helping you manage your busy schedule. Sign up today to ensure your pet gets the attention they deserve.';
        } else {
            infoElement.innerHTML = 'Struggling to find time for your pet\'s care? At PetsHub’s Daycare, we\'ve got you covered. Count on us for top-notch care while you tackle your busy schedule. Join our daycare community today to ensure your pet gets the attention they deserve.';
        }
    }

    updateInfoContent();
    window.addEventListener('resize', updateInfoContent());


    fetch('../php/checksession.php')
    .then(response => response.json())
    .then(data => {
        if (data.loggedIn === true) {
            const userId = data.userId;
            const userData = data.userData;

            // Set profile picture
            const profilePicture = userData.profile_picture_base64;
            if (profilePicture) {
                document.querySelector('.UserPfp').style.backgroundImage = `url('data:image/jpeg;base64, ${profilePicture}')`;
                document.querySelector('.UserPfp').style.backgroundRepeat = 'no-repeat';
                document.querySelector('.UserPfp').style.backgroundPosition = '50% 50%';
                document.querySelector('.UserPfp').style.backgroundSize = 'cover';
            }
            function expireCookie(name) {
                document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            }

            document.querySelector('.LogoutButton').addEventListener('click', function() {
                expireCookie('user_id');
                expireCookie('user_email');
                expireCookie('user_type');
                window.location.href = '../html/index.html';
            });

            const firstName = userData.first_name;
            const lastName = userData.last_name;
            const fullName = firstName + ' ' + lastName;
            document.querySelector('.UserName').textContent = fullName;
            
        } 
    })
    .catch(error => {
        console.error(error);
    });
}
