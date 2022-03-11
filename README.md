# Welcome to Just Unite Matrimonial service application


### Referral Program

The Referral program has the following features build in, with separate pro dashboard.

Point wise listing:
Pro member will earn 50% as commission from the payment made through general user.
No free credits is given to users through referral so that he become paid member instantly
Discount is also given to all general unpaid members to promote payment

#### For Developer
1. setting of cookies on viewing pro member profile

2. Tracking referral through set cookies, for the pro member, on new signup
passing the cookie value as hidden field on registration form.

3. Updating the pro member DB entry of: new signup

4. Setting the pro member referral code to new member database entry in users table,
for tracking new payment & commission when new member becomes paid.

5. Deletion of set referral code cookie during registration itself

6. No free credit if referral code is present on signup and photo upload

7. Update Pro member DB of total payment and commission earned  on payment order
made by new user, shown on pro member dashboard.

### Offer System

There are 2 types of offer to induce and promote members to become paid member

1. Instant offer: the offer is valid till 24 hr for new users from time of registration
2. Occasional offer or Current offer: starts and ends on special festival and events

Both the offers:
1. can be switched off from admin Site Settings box
2. can be switched on only from admin Offers Management

But
1. Instant offer by default never expires - so should not be set to expired from admin Offers Management
2. So it can be on-off from admin Site Settings page
