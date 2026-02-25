# Money Tracker Frontend

## This is the **frontend** part of the Money Tracker assessment, built with:

- HTML
- CSS
- JavaScript
- Bootstrap 5

It recreates the provided membership design and demonstrates responsive layout and basic interactivity.  
The frontend is completely separated from the Laravel backend in the `/backend` folder.

---

## Folder Structure (Frontend Only)


frontend/
├── index.html          # Landing page
├── membership.html     # Membership plans (Foundation & Economy)
├── contact.html        # Support / contact page
└── assets/
    ├── css/
    │   └── style.css   # Shared styles
    └── js/
        └── main.js     # Shared JavaScript (interactions)


### How to Run the Frontend
No build tools are required. You can open it directly or use a simple dev server.

#### Option 1: Open in Browser
Open the frontend folder.

### Double-click index.html to open it in your browser.

##### Use the navbar links to navigate:

Home → index.html

Memberships → membership.html

Support → contact.html

##### Option 2: VS Code Live Server (recommended)
Open the project in VS Code.

Right-click frontend/index.html.

Select “Open with Live Server”.(Live server is an extension in visual studio)

#### The browser will open at a URL like:

http://127.0.0.1:5500/frontend/index.html

Navigate between pages using the navbar.

##### Pages
##### 1. index.html – Home
Simple introduction to Money Tracker.

Hero section with a button linking to the Memberships page.

Small feature section describing:

Multiple wallets.

Income & expense tracking.

Overall balance overview.

Uses Bootstrap grid and is responsive.

###### 2. membership.html – Membership Plans
This is the main assessment page.

Two membership cards:

Foundation Membership

Economy Membership

Each card shows:

Plan name.

Short subtitle.

Price per month.

Key features.

Details button on each card:

Toggles the plan description (show/hide) using JavaScript.

Only one description is open at a time (accordion-like behavior).

Join button on each card:

Opens a Bootstrap modal.

The modal displays the selected plan name.

Includes a small form:

Full name (required).

Email (required).

Basic JavaScript validation:

Checks for non-empty name.

Simple @ check for email.

On success:

Shows a confirmation alert.

Closes the modal and resets the form.

###### 3. contact.html – Support
Simple contact form with:

Name.

Email.

Message.

On submit:

Shows a basic “message sent” alert.

Resets the form.

No backend call is required for this assessment.

Styling – assets/css/style.css
Uses system UI font for a clean look.

Styles membership cards:

Rounded corners.

Subtle borders and spacing.

Styles the membership description block:

Top border.

Internal padding.

Includes a small media query for better typography on small screens.

Bootstrap 5 (via CDN) is used for:

Grid system.

Navbar.

Cards.

Buttons.

Modal.

Form controls.

JavaScript – assets/js/main.js
All frontend interactivity is handled here:

Membership description toggle

Listens on .toggle-description buttons.

Reads data-target to find the corresponding description element.

Closes other descriptions before opening the selected one.

Join modal

When a “Join” button is clicked, passes the plan name (via data-plan) into the modal’s Selected Plan input.

Validates the join form (name + email).

Shows a simple alert() on success, then closes the modal and resets the form.

Contact form

Listens to contactForm submit.

Shows a simple confirmation alert and resets the form.

What to Ignore (Frontend Context)
For frontend review or development, you do not need to touch:

