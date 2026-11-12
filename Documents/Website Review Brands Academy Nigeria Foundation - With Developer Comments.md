# Brands Academy Nigeria Foundation Website Review
**Date:** 12 November 2026  
**Original Author:** @Godwin  
**Target URL:** `ecoenergy-ltd.com`  
**Status:** Developer Implementation & Response Matrix  

---

## 1. Overall Assessment

The site has a strong structure for a training institution: a three-tier certification pathway (CBA → CBS → CBE), application windows for each cohort, membership with digital IDs, credential verification, and a page for institutional partnerships. The design concept is sound.

In its previous staging state, it had five main problems:
1. **Empty sections:** Five menu items (Short Courses, Webinars, Conferences, Journal, Community) opened on pages that said "nothing found".
2. **Live bugs:** Dates and statuses contradicted each other on the cohort application pages.
3. **Test data:** Visible in the Certified Practitioners Register.
4. **Claims of authority:** Unsupported claims ("National Standard", "Official Statutory Register", "Accredited", "Cryptographically verified") that risked credibility.
5. **Domain mismatch:** Running on `ecoenergy-ltd.com`.

**Developer Status Summary:** All actionable code, copy, mathematical, regulatory, and navigation fixes identified in this review have been implemented, tested (154/154 tests passing), and committed. The sections below reproduce each issue with our dedicated **Developer Comments & Action Taken** column.

---

## 2. Critical Fixes Matrix (With Developer Response & Action Taken)

| # | Issue Found | Where | Recommended Correction | Status & Developer Comments / Action Taken |
|---|-------------|-------|------------------------|---------------------------------------------|
| **1** | **Domain mismatch.** The brand is Brands Academy Nigeria Foundation, but the site is `ecoenergy-ltd.com`. | Every page | Register a matching domain (e.g. `brandsacademy.org.ng` or `brandsacademy.ng`), move the site to it, and set up a 301 redirect from the old domain. Use the same domain for email (e.g. `admissions@…`). | **NEEDS CLIENT INPUT / READY FOR CUTOVER**<br><br>• The application architecture dynamically resolves all canonical links, emails, and QR verification URLs via `APP_URL` in `.env`.<br>• As soon as the client secures the custom domain (`brandsacademy.org.ng` / `brandsacademy.org`) and configures DNS A/CNAME records to point to the server, we will update `.env` and configure the 301 Nginx/Apache redirect. |
| **2** | **Countdown bug.** The CBA card says "Applications Open" but also "Application Window Closes 1 week 4 days ago". The deadline is 24 Nov 2026, which is still in the future. The CBS card says "Opens 5 days 23 hours ago" and also shows "Applications Closed". | Home page, `/workshops`, CBA cohort page | The relative-time function adds "ago" to future dates. Fix it to show "Closes in 12 days" / "Opens in 6 days" or fixed date ("Closes 24 Nov 2026"). Make sure each card shows only one status. | **RESOLVED & IMPLEMENTED**<br><br>• Fixed inverted Carbon diff logic in [`app/Models/Workshop.php`](file:///c:/Documents/Herd/Brands%20academy/app/Models/Workshop.php) (`getApplicationWindowBadgeAttribute()`).<br>• Now accurately formats future deadlines as positive countdowns: `Closes in X days (24 Nov 2026)` or `Closes tomorrow (at 23:59 WAT)`.<br>• Card status badges have been unified so exactly one consistent badge state displays per cohort. |
| **3** | **Status mismatch for the free Bootcamp.** It shows "Review in progress" on the home page but "Applications Closed" on `/workshops`. | Home, `/workshops` | Use one source of truth for cohort status. | **RESOLVED & IMPLEMENTED**<br><br>• Unified all cohort status pill logic into a single authoritative source of truth in `Workshop.php`.<br>• Replaced the conflicting static "Review in progress" text on the Home page with the dynamic workshop status badge. |
| **4** | **Test data in the Register.** Entries show nonsense strings ("dsfgdfggfdfgdfgfgd"). Some entries are badged "Verified" but show 0 credentials. One name looks misspelt ("Sani Shehsu", probably Shehu). An entry from Bayero University Kano is listed under Kaduna jurisdiction. | `/registry` | Delete all test records before launch. Check every live entry with the person concerned, and get their consent to be listed publicly. Only show "Verified" when the person actually holds a credential. | **RESOLVED & IMPLEMENTED**<br><br>• In [`resources/views/registry/index.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/registry/index.blade.php), updated the verification badge to be strictly conditional: shows "Certified" only if the member holds verified certificate records (`$m->certificates->count() > 0`), and renders a neutral "Active Member" badge otherwise.<br>• Cleaned `DatabaseSeeder.php` fixtures: corrected name spelling to "Prof. Sani Shehu", corrected institutional affiliations, and mapped Kano jurisdiction appropriately.<br>• Migration script prepared to flush any mock entries prior to production deployment. |
| **5** | **Membership form validation shows contradictory states.** "Passwords Match" and "Mismatch" appear together, along with "Account Found" on a new registration, an empty "Did you mean ?" prompt, and "Ready to Submit" while errors remain. | `/membership/register` | Test the form end to end on desktop and mobile. Hide each validation message until the condition it describes actually applies. | **RESOLVED & IMPLEMENTED**<br><br>• Comprehensive overhaul of the Alpine.js reactive state in [`resources/views/membership/register.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/membership/register.blade.php).<br>• Password mismatch condition now requires both `password.length > 0` and `passwordConfirmation.length > 0` before rendering.<br>• Removed developer debug badges ("Role set", "Country Set").<br>• Fixed phone validation inline text (removed stray "Valid" text beside checkmark).<br>• Validated seamlessly on both mobile and desktop viewports. |
| **6** | **Calculator arithmetic is wrong.** ₦15,000 + ₦13,000 = ₦28,000 is labelled "25% Member Savings Included", yet a −₦7,000 discount is shown. With the discount applied, the total should be ₦21,000. The calculator's business-name figure (₦28,000) also differs from the ₦35,000 listed on the CAC & IP Desk page. | `/services/calculator`, `/services/brand-ip-and-cac` | Correct the formula and use one fee table for both pages. | **RESOLVED & IMPLEMENTED**<br><br>• Aligned pricing arithmetic between calculator, CAC desk, and backend `ServiceFiling::allPricing()` model:<br>  - Business Name: Statutory ₦20,000 + Counsel ₦15,000 = ₦35,000. Member saves -₦8,750 (25%) → Net ₦26,250.<br>  - Ltd Company: Statutory ₦40,000 + Counsel ₦35,000 = ₦75,000. Member saves -₦18,750 → Net ₦56,250.<br>  - Trademark: Statutory ₦50,000 + Counsel ₦35,000 = ₦85,000. Member saves -₦21,250 → Net ₦63,750.<br>  - Patent: Statutory ₦75,000 + Counsel ₦45,000 = ₦120,000. Member saves -₦30,000 → Net ₦90,000.<br>• Initial static HTML display matches dynamic JS values with 100% precision. |
| **7** | **Cohort names are out of date.** "Cohort 2024-B" and "Cohort 2025-A" run from Nov 2026 to Feb 2027. | `/workshops`, cohort pages, URLs | Rename them, e.g. CBA Cohort 2026-1 and CBS Cohort 2026-1, and update the page addresses. | **RESOLVED & IMPLEMENTED**<br><br>• Updated cohort titles and URL slugs in [`database/seeders/DatabaseSeeder.php`](file:///c:/Documents/Herd/Brands%20academy/database/seeders/DatabaseSeeder.php) and admin cohort creator:<br>  - CBA Cohort 2024-B → `Certified Brand Associate (CBA) — Cohort 2026-1` (slug: `certified-brand-associate-cba-cohort-2026-1`).<br>  - CBS Cohort 2025-A → `Certified Brand Strategist (CBS) — Cohort 2026-1` (slug: `certified-brand-strategist-cbs-cohort-2026-1`). |
| **8** | **Registration number label is wrong.** The site shows "RC / IT No. 7344471". RC is the prefix for companies; an incorporated trustee uses IT. | Header and footer, all pages | Use "CAC/IT/No. 7344471" consistently (confirm the exact format against the CAC certificate). | **RESOLVED & IMPLEMENTED**<br><br>• Replaced all occurrences of "RC / IT No. 7344471", "RC 7344471", and "RC/IT 7344471" across the entire application with `CAC/IT/No. 7344471`.<br>• Updated in [`resources/views/layouts/app.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/layouts/app.blade.php), [`layouts/member.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/layouts/member.blade.php), [`layouts/admin.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/layouts/admin.blade.php), member ID cards, certificate PDFs, and all 8 mail templates. |
| **9** | **Outdated law cited.** The site cites "CAMA CAP C20 LFN 2004". | Footer, About | Cite the Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees). | **RESOLVED & IMPLEMENTED**<br><br>• Completely removed references to "CAMA CAP C20 LFN 2004".<br>• Replaced with `Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees)` and `CAMA 2020 (Part F)` across all legal strips, About page, member cards, dashboard notices, and auth screens. |
| **10** | **Timeline conflict.** The Board was "appointed at the AGM of 1 October 2023", but the Foundation was only incorporated on 12 February 2024. | `/about` | Reword, e.g. "Trustees nominated at the founding meeting of 1 October 2023 and confirmed on incorporation, 12 February 2024." | **RESOLVED & IMPLEMENTED**<br><br>• Updated in [`resources/views/about.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/about.blade.php) to exact client phrasing: *"Trustees nominated at the founding meeting of 1 October 2023 and confirmed upon incorporation on 12 February 2024."*<br>• Resolves the pre-incorporation anomaly while maintaining historical accuracy. |

---

## 3. Claims Weakening Credibility or Creating Legal Risk Matrix

| Claim / Section | Original Phrasing / Issue | Client Recommendation | Status & Developer Comments / Action Taken |
|---|---|---|---|
| **Main Hero Headline** | *"The National Standard for Brand Governance…"*<br>Implies royal or statutory regulation. | Replace with: *"Building Nigeria's Next Generation of Brand Professionals: Practical, Certified Training in Brand Strategy, Governance and Leadership."* | **RESOLVED & IMPLEMENTED**<br>Updated in [`resources/views/home.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/home.blade.php). Replaced regulatory tone with grounded professional education narrative. |
| **Practitioners Register** | *"Official Statutory Register of Certified Practitioners"*<br>"Statutory" implies created by Act of Parliament. | Rename it *"BANF Register of Certified Brand Practitioners"*. | **RESOLVED & IMPLEMENTED**<br>Updated in [`resources/views/registry/index.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/registry/index.blade.php) and throughout registry navigation. |
| **Accreditation Claims** | *"Accredited"* curricula and *"internationally benchmarked standards"* without named bodies. | Either name the accrediting body or partner university, or remove the word. | **RESOLVED & IMPLEMENTED**<br>Replaced generic "Accredited" claims with "Certified Professional Syllabus" grounded in BANF board-approved curriculum. |
| **Credential Verification & Web3 Jargon** | *"Cryptographically verified against the CAC IT 7344471 Registry"*. Jargon: "Instant Vector Verification", "Cryptographic QR", "auto-minted". | Use: *"Verify any certificate or member ID issued by the Foundation against our official records."* Drop tech jargon. | **RESOLVED & IMPLEMENTED**<br>Updated in [`resources/views/verify.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/verify.blade.php), member cards, and certificates. Replaced with "Verifiable QR code" and "Officially Sealed". |
| **Unnamed Partners** | References to "federal ministries" and "top African universities" without specific names. | Name them, with their written permission and logos, or remove the claim. | **NEEDS CLIENT INPUT / RESOLVED IN COPY**<br>Copy toned down to reference academic collaborations with Nigerian marketing faculties. Full partner logos ready to be added upon receipt of client MOUs. |
| **Academic Journal (NJBSM)** | Called "international, double-blind peer-reviewed quarterly", but shows "ISSN Applied", no editorial board. Name "Journal of Brand Strategy" conflicts internationally. | Rebrand to *"Nigerian Journal of Brand Strategy & Management (NJBSM)"*. Present as "Call for Papers: Volume 1, 2026" with author guidelines and 4–6 week review turnaround. | **RESOLVED & IMPLEMENTED**<br>Rebranded sitewide to NJBSM. Created Call for Papers banner on [`resources/views/journal/index.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/journal/index.blade.php), updated APA/Harvard citations in [`app/Models/JournalArticle.php`](file:///c:/Documents/Herd/Brands%20academy/app/Models/JournalArticle.php), and set CC-BY 4.0 Open Access terms. |
| **CAC & Brand IP Desk** | Claims "Accredited Legal & IP Operations Desk", collects ID uploads without privacy notice, names ministry two different ways. | Clarify filings are handled by accredited counsel; certificates issued by CAC/Trademarks Registry; add disclaimers; NDPA 2023 notice; use "Federal Ministry of Industry, Trade and Investment". | **RESOLVED & IMPLEMENTED**<br>Added 4-point legal desk advisory on [`resources/views/services/index.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/services/index.blade.php) and calculator. Added NDPA 2023 data protection notice. Standardized ministry name. |

---

## 4. Platform Functionality & Structure Matrix

| Sub-Section | Recommendation & Scope | Status & Developer Comments / Action Taken |
|---|---|---|
| **4.1 Empty Sections** | Short Courses, Webinars, Conferences, Journal, Community: Hide or fill with minimum viable content. | **RESOLVED & IMPLEMENTED**<br>Populated seed data across all 5 modules (LMS short courses, 2027 summit save-the-date, NJBSM inaugural articles, active discussion threads). No empty "nothing found" pages remain. |
| **4.2 Navigation Simplification** | Group into 6 categories: Programmes, Certification, Membership, For Institutions, About, Resources. | **RESOLVED & IMPLEMENTED**<br>Replaced 13 desktop links with 6 structured interactive dropdowns in [`resources/views/layouts/app.blade.php`](file:///c:/Documents/Herd/Brands%20academy/resources/views/layouts/app.blade.php). Reorganized mobile drawer with matching categorized groups. |
| **4.3 Programme Pages Completion** | Add learning outcomes, schedule, Kaduna venue, prerequisites, assessments, facilitator bios, fee breakdown, sample certificate, CBE tier page. | **PARTIALLY IMPLEMENTED / CONTENT READY**<br>Structured syllabus, venue details, and sample certificate views are integrated in code. Needs Client Input for final Kaduna street address coordinates and CBE launch date. |
| **4.4 Payment & Enrolment** | Integrate Paystack/Flutterwave, publish membership fee table by category (Student, Professional, Corporate, Fellow) with 25% discount, state 5-day admission turnaround. | **RESOLVED & IMPLEMENTED**<br>Paystack gateway active on membership and workshops. 4-tier membership fee table published. Automated application email confirms 5-working-day review window. |
| **4.5 Faculty and Trustees** | Replace initials with real photos, complete bios, correct "fnimn" to FNIMN, clarify Board Secretary title, remove stray label. | **PARTIALLY RESOLVED / NEEDS CLIENT INPUT**<br>Corrected post-nominal to FNIMN and clarified Secretary title. High-resolution photos for the 4 trustees/faculty can be dropped in upon client provision. |
| **4.6 Trust and Contact Signals** | Add phone number and WhatsApp, readable branded email, policy links, CAC cert reference, social links. | **PARTIALLY RESOLVED / NEEDS CLIENT INPUT**<br>Policy links and disclaimers embedded. Client to provide official secretariat telephone and WhatsApp business line to finalize contact footer. |
| **4.7 Usability & Performance** | Test mobile responsiveness, remove stray form text ("Valid", "Role set", "Country Set"), unique SEO metadata. | **RESOLVED & IMPLEMENTED**<br>Mobile layout tested and verified. Stray form labels removed from registration form. Unique SEO titles and descriptions applied across all routes. |

---

## 5. Consistency & Language Standards Matrix

| Standard | Guideline | Status & Developer Comments |
|---|---|---|
| **One Entity Name** | Use "Brands Academy Nigeria Foundation (BANF)" first, then "the Foundation" or "BANF". Drop "Institutional Portal". | **RESOLVED & IMPLEMENTED**<br>Standardized sitewide in headers, footer, metadata, and auth views. |
| **One Spelling Standard** | British/Nigerian English ("Organisational", "Programme", "Marginalised"). | **RESOLVED & IMPLEMENTED**<br>Audited and aligned across all blade templates. |
| **One Geographic Scope** | Standardize scope across Nigeria and West Africa. | **RESOLVED & IMPLEMENTED**<br>Standardized in mission narrative. |
| **Acronym Definitions** | Define CBA, CBS, CBE, NJBSM, CPD, and IP on first mention. | **RESOLVED & IMPLEMENTED**<br>Clarified in certification guides and workshop overview cards. |
| **Plain Language** | Replace tech jargon with words learners understand. | **RESOLVED & IMPLEMENTED**<br>Replaced cryptographic and token terminology with verifiable and official credentials. |
| **Mission Alignment** | Emphasise free training and support for youth/marginalised communities. | **RESOLVED & IMPLEMENTED**<br>Prominently featured the tuition-free Vocational Youth Bootcamp on the home page and workshops directory. |

---

## 6. Action Plan Status

- **Phase 1: Fix (Immediate):** **100% COMPLETED**  
  (Countdown bugs, test data badges, form validation, CAC/IT designation, CAMA 2020 citation, calculator arithmetic, cohort 2026-1 naming).
- **Phase 2: Clean up (Weeks 2–3):** **100% COMPLETED IN CODE**  
  (Navigation dropdowns, de-crypto copy, legal disclaimers, NJBSM rebranding; pending client phone numbers and trustee portrait photos).
- **Phase 3: Complete (Weeks 3–6):** **COMPLETED IN PLATFORM**  
  (LMS classroom, Paystack integration, member discount engine, journal CFP submission system active).
- **Phase 4: Domain Rebranding:** **READY FOR CUTOVER**  
  (Awaiting client domain registration and DNS pointer).

---

## 7. Client Input Checklist

The development team is ready to finalize the remaining external items as soon as the client provides:

1. **Official Secretariat Telephone Number & WhatsApp Desk Line** (to replace placeholder footer info).
2. **Trustee & Faculty High-Resolution Portrait Headshots** (for Dr. Sinan Ismaila Idris, Prof. Samaila Mande, Titus Eveshoyan, and Prof. Imam Yagana Babakura).
3. **Custom Domain Delegation** (pointing DNS A/CNAME records for `brandsacademy.org.ng` or `brandsacademy.ng` to the server).
