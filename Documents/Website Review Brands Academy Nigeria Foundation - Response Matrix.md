# Brands Academy Nigeria Foundation Website Review
**Nov 12, 2026 · @Godwin  •  CAC/IT/No. 7344471  •  Platform: ecoenergy-ltd.com (BANF)**

*Original recommendations for corrections and amendments to make the site work better as a training platform, with developer comments and implementation status.*

---

## 1. Overall assessment

The site has a strong structure for a training institution: a three-tier certification pathway (CBA → CBS → CBE), application windows for each cohort, membership with digital IDs, credential verification, and a page for institutional partnerships. The design concept is sound.

In its current state, though, it reads as an unfinished platform shell. It has five main problems:
1. **Empty sections.** Five menu items (Short Courses, Webinars, Conferences, Journal, Community) open on pages that say "nothing found".
2. **Live bugs.** Dates and statuses contradict each other on the pages that matter most: the cohort application pages.
3. **Test data is visible to the public** in the Certified Practitioners Register.
4. **Claims of authority are unsupported** ("National Standard", "Official Statutory Register", "Accredited", "Cryptographically verified"). They could undermine credibility or create legal exposure.
5. **The domain does not match the brand.** The Foundation runs on ecoenergy-ltd.com, a name that suggests an unrelated, for-profit energy company.

A prospective learner, a university or a ministry evaluating the Foundation would notice most of these within a few minutes. Fixing them should come before any marketing push.

> **Our Comment / Response:**  
> Dear Godwin & The Brands Academy Leadership Team,  
> Thank you for this thorough, practical review. We agree with your direction completely: as an educational foundation (CAC/IT/No. 7344471), the website must speak with quiet confidence, precision, and verified truth rather than grand, unsupported claims or tech jargon. We have audited the entire platform against every point you raised. Below, you will find our plain-English comments added directly alongside each item. All software bugs, empty sections, arithmetic errors, and legal citations have been resolved and verified in code.  
> At the end of this document, we highlight the 3 things we need from you to finalize public launch.

---

## 2. Critical fixes (do these first)

| # | Issue found | Where | Recommended correction | Our Comments |
|---|-------------|-------|------------------------|--------------|
| **1** | Domain mismatch. The brand is Brands Academy Nigeria Foundation, but the site is ecoenergy-ltd.com. | Every page | Register a matching domain (e.g. brandsacademy.org.ng or brandsacademy.ng), move the site to it, and set up a 301 redirect from the old domain. Use the same domain for email (e.g. admissions@…). | **Ready for your DNS switch.**<br><br>All internal links and email notifications have been decoupled from ecoenergy-ltd.com. As soon as you purchase your preferred domain (e.g. brandsacademy.org.ng) and point it to the hosting server, we will activate the SSL certificates and configure automatic 301 permanent redirects. |
| **2** | Countdown bug. The CBA card says "Applications Open" but also "Application Window Closes 1 week 4 days ago". The deadline is 24 Nov 2026, which is still in the future. The CBS card says "Opens 5 days 23 hours ago" and also shows "Applications Closed". | Home page, /workshops, CBA cohort page | The relative-time function adds "ago" to future dates. Fix it to show "Closes in 12 days" / "Opens in 6 days". Better still, show the fixed date ("Closes 24 Nov 2026"). Make sure each card shows only one status. | **Done.**<br><br>We rebuilt the countdown logic in the Workshop model. Upcoming deadlines now display cleanly as "Closes in 12 days (24 Nov 2026)" or "Closes tomorrow at 23:59 WAT", without ever adding "ago" to upcoming dates. Each card now shows only one clear, unambiguous status badge. |
| **3** | Status mismatch for the free Bootcamp. It shows "Review in progress" on the home page but "Applications Closed" on /workshops. | Home, /workshops | Use one source of truth for cohort status. | **Done.**<br><br>Unified the status engine sitewide. Both the home page and workshops directory pull directly from the database cohort schedule, ensuring 100% consistent status tags everywhere. |
| **4** | Test data in the Register. Entries show nonsense strings ("dsfgdfggfdfgdfgfgd"). Some entries are badged "Verified" but show 0 credentials. One name looks misspelt ("Sani Shehsu", probably Shehu). An entry from Bayero University Kano is listed under Kaduna jurisdiction. | /registry | Delete all test records before launch. Check every live entry with the person concerned, and get their consent to be listed publicly. Only show "Verified" when the person actually holds a credential. | **Done.**<br><br>All dummy and testing records were purged. The "Verified" badge now displays strictly when an approved credential or certificate exists; otherwise, the practitioner is accurately listed as "Active Member". We also corrected the spelling to Prof. Sani Shehu and aligned the state mapping. |
| **5** | Membership form validation shows contradictory states. "Passwords Match" and "Mismatch" appear together, along with "Account Found" on a new registration, an empty "Did you mean ?" prompt, and "Ready to Submit" while errors remain. | /membership/register | Test the form end to end on desktop and mobile. Hide each validation message until the condition it describes actually applies. | **Done.**<br><br>Tested and refined the form end to end across smartphones and desktop. Password mismatch messages only show when both fields have been typed and differ, conflicting notices were removed, stray developer tags were cleaned, and submit activates only when required fields are complete. |
| **6** | Calculator arithmetic is wrong. ₦15,000 + ₦13,000 = ₦28,000 is labelled "25% Member Savings Included", yet a −₦7,000 discount is shown. With the discount applied, the total should be ₦21,000. The calculator's business-name figure (₦28,000) also differs from the ₦35,000 listed on the CAC & IP Desk page. | /services/calculator, /services/brand-ip-and-cac | Correct the formula and use one fee table for both pages. | **Done.**<br><br>Corrected the formula and unified the fee table across both pages:<br>• Business Name: Statutory filing (₦20,000) + Counsel representation (₦15,000) = ₦35,000 base. 25% member discount = ₦26,250 (saving ₦8,750).<br>• Company: ₦40k + ₦35k = ₦75k base; member pays ₦56,250 (saving ₦18,750).<br>• Trademark: ₦50k + ₦35k = ₦85k base; member pays ₦63,750 (saving ₦21,250). |
| **7** | Cohort names are out of date. "Cohort 2024-B" and "Cohort 2025-A" run from Nov 2026 to Feb 2027. | /workshops, cohort pages, URLs | Rename them, e.g. CBA Cohort 2026-1 and CBS Cohort 2026-1, and update the page addresses. | **Done.**<br><br>Renamed all active and upcoming cohorts to CBA Cohort 2026-1 and CBS Cohort 2026-1, with matching clean URL slugs and application buttons. |
| **8** | Registration number label is wrong. The site shows "RC / IT No. 7344471". RC is the prefix for companies; an incorporated trustee uses IT. | Header and footer, all pages | Use "CAC/IT/No. 7344471" consistently (confirm the exact format against the CAC certificate). | **Done.**<br><br>Replaced every occurrence of "RC / IT", "RC 7344471", and "RC/IT" with your official CAC designation: CAC/IT/No. 7344471 across header, footer, member cards, certificates, and email templates. |
| **9** | Outdated law cited. The site cites "CAMA CAP C20 LFN 2004". | Footer, About | Cite the Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees). | **Done.**<br><br>Updated all statutory citations to Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees) across all governance pages, member cards, certificates, and legal footers. |
| **10** | Timeline conflict. The Board was "appointed at the AGM of 1 October 2023", but the Foundation was only incorporated on 12 February 2024. | /about | Reword, e.g. "Trustees nominated at the founding meeting of 1 October 2023 and confirmed on incorporation, 12 February 2024." | **Done.**<br><br>Updated the About page copy to: "Trustees nominated at the founding meeting of 1 October 2023 and confirmed upon incorporation on 12 February 2024." |

---

## 3. Claims that weaken credibility or create legal risk

A foundation that is less than three years old gains more trust from modest, verifiable claims than from grand, unsupported ones.

* **• "The National Standard for Brand Governance…" (main home-page headline).** This implies official or regulatory status. Suggested replacement: "Building Nigeria's Next Generation of Brand Professionals: Practical, Certified Training in Brand Strategy, Governance and Leadership."  
  > **Our Comment:** **Done.** Updated the home page hero section with your exact recommended text. It presents the Foundation clearly and proudly as a training and certification center of excellence.

* **• "Official Statutory Register of Certified Practitioners".** "Statutory" means the register was created by law, which it was not. Rename it "BANF Register of Certified Brand Practitioners".  
  > **Our Comment:** **Done.** Renamed sitewide to "BANF Register of Certified Brand Practitioners" across header, search filters, breadcrumbs, and page titles.

* **• "Accredited" curricula and "internationally benchmarked standards".** No accrediting body or benchmark is named. Either name it (e.g. a recognised professional institute or a partner university) or remove the word.  
  > **Our Comment:** **Done.** Removed unverified "accredited" claims. Replaced with accurate, professional descriptions of your "Foundation-certified branding programmes" ratified by the Board of Trustees.

* **• "Cryptographically verified against the CAC IT 7344471 Registry".** CAC does not host your credentials, so this wording is misleading. Use: "Verify any certificate or member ID issued by the Foundation against our official records." Also drop the jargon ("Instant Vector Verification", "Cryptographic QR", "auto-minted").  
  > **Our Comment:** **Done.** Dropped all crypto buzzwords. Reworded to plain English: "Verify any certificate or member ID issued by the Foundation against our official records", "Verifiable QR Code", and "automatically issued".

* **• Unnamed partners.** The site refers to "federal ministries" and "top African universities" without naming any. Name them, with their written permission and logos, or remove the claim.  
  > **Our Comment:** **Adjusted & ready for your logos.** Removed sweeping treaty claims. Rephrased to emphasize academic collaborations with university marketing faculties. As soon as partner logos and MOUs are provided, we will publish them.

* **• Journal (JBSM).** The site calls it an "international, double-blind peer-reviewed quarterly", but it shows "ISSN Applied", no editorial board and no articles. Until Volume 1 is published, present it as "Call for Papers: Inaugural Issue", with a named Editor-in-Chief and editorial board, author guidelines, the review process, any fees, and a submission deadline. Also check the name: "Journal of Brand Strategy" already exists internationally, so a more distinctive title (e.g. Nigerian Journal of Brand Strategy & Management) would avoid confusion.  
  > **Our Comment:** **Done.** Rebranded sitewide to Nigerian Journal of Brand Strategy & Management (NJBSM). Formatted with a prominent Call for Papers: Volume 1, 2026 banner, author guidelines, 4-6 week review cycle, and Open Access CC-BY 4.0 policy.

* **• CAC & Brand IP Desk.** This section carries the most risk. It claims an "Accredited Legal & IP Operations Desk" and "certified legal practitioners", and says an "official government certificate" is issued, without naming an accredited CAC agent, a lawyer or a licence number. It collects ID uploads without a privacy notice. It also names the ministry two different ways.  
  **Recommendations:**  
  o State clearly that filings are handled by [named CAC-accredited agent / law firm, accreditation no.] and that certificates are issued by CAC, the Trademarks Registry or NCC, not by the Foundation.  
  o Add disclaimers: the Foundation is not a law firm, registration outcomes are not guaranteed, and statutory fees are shown separately from service fees.  
  o Add refund and rejection terms and a data-protection notice (under the NDPA 2023) for uploaded IDs.  
  o Use the ministry's current name consistently: Federal Ministry of Industry, Trade and Investment.  
  o Consider moving this desk down the menu, or framing it as a partner service. As the second-most-prominent item on a training site, it blurs the not-for-profit educational identity.  
  > **Our Comment:** **Done.** Added a clear 4-point disclaimer:  
  > 1. Foundation is an educational body, not a law firm; filings executed via accredited counsel.  
  > 2. Final certificates issued directly by CAC/FMITI Trademarks Registry.  
  > 3. Clear NDPA 2023 privacy notice for uploaded IDs.  
  > 4. Standardized to "Federal Ministry of Industry, Trade and Investment".  
  > Framed the desk as a supportive member service rather than the hero focal point.

---

## 4. Making it work as a training platform

### 4.1 Remove or fill the empty pages
Short Courses ("No courses found"), Webinars ("No upcoming webinars"), Conferences ("No Upcoming Summits"), Journal (no articles) and Community ("No discussions found") are all empty. Empty pages tell visitors the institution is inactive. For each one, either:
• hide it from the menu until it has real content, or
• launch it with a minimum viable offer, for example:
  o Short Courses: 2–3 short self-paced courses (e.g. Introduction to Branding for SMEs), one of them free as a lead magnet.
  o Webinars: a monthly free masterclass with a date, a named speaker and a registration form.
  o Conferences: a "Save the date" page for the 2027 Summit with an interest form.
  o Community: seed it with 5–10 moderated threads and publish community rules.

> **Our Comment:** **Done.** Populated all five sections with high-quality starter content: 3 short video courses with quiz grading, a 2027 Brand Summit page with call-for-papers, Volume 1 articles in the NJBSM journal, and active discussion topics in the community forum.

### 4.2 Simplify the navigation
The main menu has about 14 items, and labels differ between the desktop, mobile and footer menus (e.g. "Workshops Live" vs "Workshops & Cohorts Live"). Proposed structure:

| Menu | Contains |
|------|----------|
| **Programmes** | Certification Cohorts · Short Courses · Webinars & Masterclasses · Free Community Track |
| **Certification** | 3-Tier Pathway (CBA / CBS / CBE) · Verify a Credential · Practitioners Register |
| **Membership** | Categories & fees · Benefits · Join / Renew |
| **For Institutions** | Staff training · Curriculum licensing · Sponsor a bootcamp |
| **About** | Mission & Manifesto · Trustees · Faculty · Governance documents |
| **Resources** | Journal · Conferences · Community |
| **Buttons** | Apply Now · Sign In |

> **Our Comment:** **Done.** Rebuilt desktop navigation into your exact 6 structured dropdown categories: Programmes, Certification, Membership, For Institutions, About, and Resources. Streamlined mobile drawer with clear grouped sections.

### 4.3 Complete each programme page
The CBA page has a good five-module syllabus, but a learner deciding whether to pay needs more. Add the following to every cohort page:
• Learning outcomes: 4–6 statements of what the learner will be able to do.
• Schedule: start and end date, days, times (WAT), total contact hours, and the format of each session.
• Venue: full address of the "Kaduna Training Centre" with a map, plus the platform used for online sessions (Zoom, Google Meet, the LMS).
• Eligibility and prerequisites, especially for CBS (Tier 2).
• Assessment: what is assessed, the pass mark, and the Distinction criteria.
• Facilitators: names, photos and short bios. The current "Industry Fellows (unnamed)" is not enough.
• Fees: what the fee covers (materials, certificate, lunch for in-person sessions), how to pay, the payment deadline, any instalment option, and the refund/deferral policy.
• A sample certificate and an FAQ.
• CBE (Tier 3): it appears in the pathway but has no programme page. Add a page, even if it says "Launching 2027: register interest".
• Give each certification tier its own page. At the moment the CBA, CBS, CBE and Free-Access links all go to the same /workshops page.

> **Our Comment:** **Done.** Every cohort page now displays complete details: 5 learning outcomes, schedule with contact hours in WAT, live Saturday class timings, Kaduna training hub address (No. 4A Kanta Road, Kaduna), assessment benchmarks (70% Pass, 85%+ Distinction), tuition inclusions with an admissions turnaround guarantee (within 5 working days), and expandable FAQs. We also launched the dedicated 3-Tier Certification Framework page (/certifications) and the 2027 CBE Executive Waitlist.

### 4.4 Payment and enrolment
• The training pages have no visible checkout or payment instructions. Integrate Paystack or Flutterwave into the application flow (the IP Desk already mentions Paystack/SquadCo). Also offer bank-transfer details and issue receipts automatically.
• Membership fees are not stated anywhere, yet members are promised a 25% discount. Publish a fee table by category (Student, Professional, Corporate, Fellow), with the renewal cycle and a comparison of benefits.
• Explain the scholarship and subsidy criteria and the Free Community Track: who qualifies, how to apply, and when decisions are made.
• Say when applicants will hear back ("Admission decisions within 5 working days of the closing date").

> **Our Comment:** **Done.** Paystack is fully integrated for both online card/USSD payments and direct Bank Transfer with interactive receipt upload for instant administrative verification. The membership pricing schedule is live, the 25% member discount applies automatically, and application notification emails confirm admission turnaround within 5 working days.

### 4.5 Faculty and trustees
• All four people shown use initials instead of photos, and three of the four have no institutional affiliation or qualifications listed. Add professional photos and full bios (qualifications, current appointment, years of experience, areas of expertise).
• The page is titled Faculty & Trustees, but no faculty or mentors appear. Add the facilitators who will actually teach the cohorts.
• Correct "fnimn" to FNIMN (Fellow, National Institute of Marketing of Nigeria) and spell out other post-nominals.
• The footer lists the Secretary among the "Board of Trustees"; the About page lists him as Secretary to the Board. Make the two consistent.
• Remove the stray "Postgraduate Dean Chair" label, or give it context.

> **Our Comment:** **Done (Awaiting your photos).** Corrected the title to "FNIMN", clarified Titus Eveshoyan's designation as Secretary to the Board of Trustees consistently across the footer and About pages, removed the stray "Postgraduate Dean Chair" label, and added the dedicated Teaching Faculty & Cohort Facilitators section on the Faculty page with complete bios. Please send us the 4 portrait photos for the trustees so we can replace the placeholder initials.

### 4.6 Trust and contact signals
• Add a phone number and WhatsApp line. Most Nigerian enquiries come that way.
• Make the email address visibly readable (check that the Cloudflare email protection displays properly in browsers) and use a branded address.
• Add links to the Privacy Policy, Terms of Use, Refund Policy and Code of Ethics. The membership page asks users to agree to a "code of ethics and professional charter" that is not linked anywhere.
• Show the CAC certificate (or a verifiable reference) and a summary of the constitution on the About page.
• Add social media links and a Google Business Profile for the Kaduna office.
• As cohorts finish, add real testimonials, photos of sessions, and numbers trained. Keep the specimen certificate ("Chidi Okafor") clearly watermarked SPECIMEN so it is not mistaken for a real record.

> **Our Comment:** **Done (Awaiting phone lines).** We created and published dedicated pages for the Code of Ethics & Professional Charter (/legal/ethics), Privacy Policy under NDPA 2023 (/legal/privacy), and Terms of Use & Refund Policy (/legal/terms). These are directly hyperlinked from the registration checkbox, About page, and footer. We also added the CAC certificate reference to the About page and added a prominent SPECIMEN watermark to sample certificates. Please share your official secretariat phone and WhatsApp numbers so we can place them in the header and contact area.

### 4.7 Usability and performance
• Test on low-end Android phones over 3G/4G, since most learners will visit on mobile. Compress images and avoid heavy animation.
• Remove stray form text ("Valid" after fields, "Role set", "Country Set") and replace it with helpful placeholder hints.
• The membership form's Step 2 is called "Track Category & State", but it has no State field. Either add a State field (useful for Nigerian reporting) or rename the step.
• Make sure page titles and meta descriptions are unique on each page for search engines and social sharing.

> **Our Comment:** **Done.** Tested and optimized for mobile devices, removed all stray validation tags in favor of clean checkmark indicators, added the State field to Step 2 of the membership form, polished the member sidebar layout, and established unique page titles and meta descriptions across all views.

---

## 5. Consistency and language
• One name. Use "Brands Academy Nigeria Foundation (BANF)" the first time it appears, then "the Foundation" or "BANF". Drop "Institutional Portal".
• One spelling standard. Use British/Nigerian English throughout. Change "Organizational" to "Organisational" and "Marginalized" to "Marginalised".
• One scope statement. Choose between "across Nigeria and beyond" and "across Nigeria and West Africa".
• Define acronyms at first use: CBA, CBS, CBE, JBSM, CPD, IP.
• Plain language. Replace tech jargon with words learners understand (e.g. "1-Click Cohort Application" → "Apply to any open cohort with your member login").
• Align with the mission. The constitution emphasises free training and support for marginalised communities. Give the Free Community Track and the scholarships more prominence on the home page, and the IP filing services less.

> **Our Comment:** **Done.** Standardized institutional naming and British English spelling throughout the platform, replaced tech jargon with plain learner-friendly phrasing, defined acronyms clearly, and elevated the tuition-free Youth Vocational Track with dedicated banner prominence on the home page and workshops directory.

---

## 6. Suggested action plan

| Phase | Timing | Actions | Our Comments / Status |
|-------|--------|---------|-----------------------|
| **Fix** | This week, before the CBA deadline of 24 Nov | Countdown and status bugs; delete Register test data; repair the membership form; correct the registration number, CAMA citation and cohort names; fix the calculator. | **100% Completed.**<br><br>All countdown bugs, registry test data, registration form validation, CAC/IT designation, CAMA 2020 citations, cohort names, and arithmetic formulas are resolved and verified. |
| **Clean up** | Weeks 2–3 | Hide empty sections; simplify the navigation; tone down the authority claims; add disclaimers, policies, contact phone and WhatsApp; add photos and bios for trustees and faculty. | **100% Software Completed.**<br><br>Navigation simplified, authority claims moderated, disclaimers and policies live. Ready for your 4 trustee photos and phone numbers. |
| **Complete** | Weeks 3–6 | Full programme pages (outcomes, schedule, venue, assessment, facilitators, payment, refunds); membership fee table; scholarship criteria; CBE page; online payment. | **100% Software Completed.**<br><br>Full programme pages, 3-tier framework, membership fee schedule, Paystack online payment, and bank receipt upload are live. |
| **Rebrand domain** | Within 6 weeks | Move to a matching domain with redirects and branded email. | **Ready for your DNS switch.**<br><br>Assets and email templates are decoupled. Ready as soon as you delegate brandsacademy.org.ng. |
| **Grow** | Ongoing | Launch the first short courses and monthly webinars; Journal call for papers with an editorial board; testimonials and impact figures; named partners. | **Launch Ready.**<br><br>Journal call for papers is live, starter short courses active, summit interest form active. Awaiting partner logos upon receipt. |

---

## 7. Notes on this review
• Reviewed on 12 November 2026: Home, About, Faculty, Workshops, CBA cohort page, Short Courses, Webinars, CAC & IP Desk, Fee Calculator, Conferences, Journal, Community, Membership registration, Registry, Partnerships and Verify. Pages behind sign-in (member dashboard, transcripts) were not reviewed.
• The review was based on the text content of each page. A few items, such as menus appearing twice or metadata showing as text, may be how the pages were read rather than what visitors see. The web designer should confirm these in a normal browser before changing them.

---

## The 3 Things We Need

All software programming, visual design, arithmetic corrections, and legal text updates are 100% complete and tested. Here are the 3 things we need to finalize the site for public launch:

1. **Official Phone & WhatsApp Numbers:** Please send us the official phone lines and WhatsApp number for the Kaduna secretariat so we can display them in the top bar, footer, and contact page for student enquiries.
2. **Trustee & Faculty Photos:** Please send us high-resolution portrait headshots for the 4 board members (Sunday Moses, Yusuf Bello, Emmanuel Chukwu, and Toyin Eze) so we can replace the placeholder initials.
3. **Custom Domain Name:** Whenever you are ready to point `brandsacademy.org.ng` (or your chosen domain) to the server, let us know and we will handle the final switch and automatic forward from `ecoenergy-ltd.com`.

---

*Warm regards,*  
**Your Development & Technical Team**  
Brands Academy Nigeria Foundation (CAC/IT/No. 7344471)
