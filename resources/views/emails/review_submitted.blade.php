{{-- Review Submitted Notification --}}

# Dear {{ $user->fullname }},

We are pleased to inform you that a review has been submitted for your manuscript:

**Title:** {{ $journal->title }}

**Reviewer:** {{ $reviewer->fullname }}
**Review Completed:** {{ now()->format('M j, Y \a\t g:i A') }}
**Recommendation:** {{ ucfirst(str_replace('_', ' ', $recommendation)) }}

## Next Steps

Your manuscript is progressing through our peer review process. You will receive additional notifications as more reviews are completed and editorial decisions are made.

You can track the status of your manuscript by logging into your author dashboard at any time.

<a href="{{ route('dashboard') }}" style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0;">
    View Your Dashboard
</a>

## Important Notes

- This notification confirms that one reviewer has completed their assessment
- The editorial team will contact you once all reviews are received and a decision is made
- Please do not reply to this email as it is sent from an automated system

Thank you for choosing our journal for your research publication.

Best regards,<br>
**Editorial Team**<br>
{{ config('app.name') }}

---
*This is an automated notification. For questions about your submission, please contact our editorial office.*
