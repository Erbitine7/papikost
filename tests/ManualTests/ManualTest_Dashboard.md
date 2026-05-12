# Manual Test: Dashboard

## Objective
Verify that the dashboard displays correct KPIs and recent sessions.

## Preconditions
- Staff is logged in
- Database has some computers, members, and billing sessions

## Test Steps
1. Log in as staff
2. Navigate to /dashboard
3. Check the displayed counts:
   - Active sessions count
   - Available PCs count
   - Total members count
   - Today's revenue
4. Check recent sessions list (last 5 sessions)
5. Verify data accuracy by comparing with database

## Expected Results
- All counts are accurate
- Recent sessions show correct data (start time, end time, amount, computer, member)
- Page loads without errors

## Edge Cases
- No active sessions: Count should be 0
- No available PCs: Count should be 0
- No members: Count should be 0
- No revenue today: Should show 0
- No recent sessions: List should be empty