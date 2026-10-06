@extends('layouts.whitepaper')

@section('hero')
    <p class="wp-eyebrow">DMS White Paper</p>
    <p class="wp-hero-sub">Document management architecture, departmental routing, tracking, and controlled release</p>
    <h1>A unified document layer for government offices, LGU departments, and private organizations</h1>
    <p class="wp-hero-desc">
        This white paper describes the Document Management System (DMS) as an operational platform for
        storing, classifying, tracking, and releasing records across organizational units. It supports
        local government departments—from treasury and civil registry to engineering and health—as well as
        private-sector divisions such as finance, legal, HR, and operations, informed by the current
        Laravel implementation, hierarchy model, and API patterns in production code.
    </p>
    <p class="wp-audience">Documentation for government stakeholders, enterprise implementers, and technical reviewers</p>
    <div class="wp-meta-grid">
        <div class="wp-meta-card"><div class="label">Platform role</div><div class="value">Document management</div></div>
        <div class="wp-meta-card"><div class="label">Scope</div><div class="value">Government + private orgs</div></div>
        <div class="wp-meta-card"><div class="label">Capabilities</div><div class="value">Track, release, API</div></div>
        <div class="wp-meta-card"><div class="label">Structure</div><div class="value">Multi-department hierarchy</div></div>
    </div>
@endsection

@section('toc')
    <li><a href="#section-1">1. Platform overview</a></li>
    <li><a href="#section-2">2. System participants</a></li>
    <li><a href="#section-3">3. Document lifecycle</a></li>
    <li><a href="#section-4">4. Organizational routing</a></li>
    <li><a href="#section-5">5. Classification and release framework</a></li>
    <li><a href="#section-6">6. API and system integrations</a></li>
    <li><a href="#section-7">7. System architecture</a></li>
    <li><a href="#section-8">8. Security and access controls</a></li>
    <li><a href="#section-9">9. Risk management framework</a></li>
    <li><a href="#section-10">10. Operational resilience</a></li>
    <li><a href="#section-11">11. Platform role summary</a></li>
@endsection

@section('content')
    <section id="section-1">
        <h2>1. Platform overview</h2>
        <p class="section-lead">Role in organizational record management and controlled disclosure</p>
        <p>
            DMS operates as a centralized document management platform for any deploying organization—municipal
            and city LGUs, provincial offices, national agencies, NGOs, and private companies. Unlike ad-hoc
            file shares or department-specific drives, DMS maintains a consistent hierarchy, access policy,
            document metadata, file history, and release channels for operational and compliance use.
        </p>
        <p>
            Each office maps its real structure into the system: treasury, assessor, civil registry, business
            permits, engineering, social services, or corporate finance and legal teams each receive scoped
            folders, permissions, and document types appropriate to their workflows.
        </p>
        <h3>Core platform functions</h3>
        <ul>
            <li>Document Management — upload, classify, version, and manage files with title, author, tags, and document date.</li>
            <li>Document Finder — search, filter, download, update permissions, and manage attached files.</li>
            <li>Folder Management — organize records within a configurable location hierarchy.</li>
            <li>Organizational hierarchy — Branch, Department, Division, and Section model for government and private org charts.</li>
            <li>Controlled release — public, private, and confidential access levels with API and file-serving endpoints.</li>
            <li>OAuth2 API (Laravel Passport) and listing endpoints for downstream portals and line-of-business systems.</li>
        </ul>
    </section>

    <section id="section-2">
        <h2>2. System participants</h2>
        <p class="section-lead">Distinct roles across government and non-government deployments</p>
        <h3>Records and document administrators</h3>
        <p>Configure branches, departments, folders, users, and organization-wide document policies.</p>
        <h3>Department staff</h3>
        <p>
            Encode, upload, and maintain documents for their unit—e.g. tax assessments, civil registry
            certificates, budget reports, permit files, contracts, or internal memos—within assigned locations.
        </p>
        <h3>Reviewers and releasing officers</h3>
        <p>Validate document metadata, adjust access levels, and authorize release to staff, partner systems, or public channels.</p>
        <h3>Citizens and external requesters</h3>
        <p>Receive documents published at public access level through integrated portals or approved download links.</p>
        <h3>API consumers and partner systems</h3>
        <p>
            HR platforms, citizen portals, legislative systems, ERP modules, and third-party reporting tools
            consume document listings and files via OAuth-protected or public API routes per integration contract.
        </p>
    </section>

    <section id="section-3">
        <h2>3. Document lifecycle</h2>
        <p class="section-lead">From intake to tracked storage and authorized release</p>
        <div class="wp-flow">
            <span class="wp-flow-item">Intake</span>
            <span class="wp-flow-arrow">→</span>
            <span class="wp-flow-item">Classify</span>
            <span class="wp-flow-arrow">→</span>
            <span class="wp-flow-item">Route to unit</span>
            <span class="wp-flow-arrow">→</span>
            <span class="wp-flow-item">Track &amp; store</span>
            <span class="wp-flow-arrow">→</span>
            <span class="wp-flow-item">Release</span>
        </div>
        <div class="wp-steps">
            <div class="wp-step"><span class="step-num">1</span><div><h4>Document intake</h4><p>A staff user or integration creates a document record and uploads one or more files with metadata.</p></div></div>
            <div class="wp-step"><span class="step-num">2</span><div><h4>Classification</h4><p>Document type, tags, and document date are applied for search, reporting, and retention alignment.</p></div></div>
            <div class="wp-step"><span class="step-num">3</span><div><h4>Organizational routing</h4><p>The record is assigned to the correct branch, department, division, section, and folder.</p></div></div>
            <div class="wp-step"><span class="step-num">4</span><div><h4>Tracking and custody</h4><p>File history, permissions, and folder location provide an auditable chain of custody within the organization.</p></div></div>
            <div class="wp-step"><span class="step-num">5</span><div><h4>Authorized release</h4><p>Documents move to the appropriate access level—internal, partner API, or public listing—for approved disclosure.</p></div></div>
            <div class="wp-step"><span class="step-num">6</span><div><h4>Retrieval and delivery</h4><p>Staff and integrated systems retrieve files via Document Finder, API responses, or the file-serving route.</p></div></div>
        </div>
    </section>

    <section id="section-4">
        <h2>4. Organizational routing</h2>
        <p class="section-lead">Mapping real offices and departments into DMS structure</p>
        <p>
            DMS uses a four-level location model—Branch, Department, Division, Section—plus Folders under each
            path. This maps cleanly to LGU line offices and to private organizational charts without custom schema per client.
        </p>
        <h3>Example LGU department mapping</h3>
        <div class="wp-data-cards">
            <div class="wp-data-card"><h4>Treasury / Finance</h4><p>Collection reports, OR registers, disbursement vouchers, and revenue summaries.</p></div>
            <div class="wp-data-card"><h4>Assessor / Taxes</h4><p>Tax declarations, assessment rolls, and real property records.</p></div>
            <div class="wp-data-card"><h4>Civil Registry</h4><p>Birth, marriage, and death records; certificates and registry books.</p></div>
            <div class="wp-data-card"><h4>Business Permits &amp; Licensing</h4><p>Permit applications, inspection reports, and renewal documents.</p></div>
            <div class="wp-data-card"><h4>Engineering / Planning</h4><p>Building plans, infrastructure files, and project documentation.</p></div>
            <div class="wp-data-card"><h4>Health &amp; Social Services</h4><p>Program records, beneficiary files, and compliance documents.</p></div>
        </div>
        <h3>Example private organization mapping</h3>
        <div class="wp-data-cards">
            <div class="wp-data-card"><h4>Finance &amp; Accounting</h4><p>Invoices, statements, audit workpapers, and policy documents.</p></div>
            <div class="wp-data-card"><h4>Human Resources</h4><p>Employee files, contracts, and training records (confidential access).</p></div>
            <div class="wp-data-card"><h4>Legal &amp; Compliance</h4><p>Contracts, regulatory filings, and board resolutions.</p></div>
            <div class="wp-data-card"><h4>Operations</h4><p>SOPs, vendor documents, and project deliverables shared across teams.</p></div>
        </div>
        <p>
            Folder lookup by location (<code>GET /get-folder-by-location</code>) supports dynamic UI flows when staff
            select branch and department before upload or search.
        </p>
    </section>

    <section id="section-5">
        <h2>5. Classification and release framework</h2>
        <p class="section-lead">Access levels, document types, and controlled disclosure</p>
        <h3>Access levels</h3>
        <div class="wp-data-cards">
            <div class="wp-data-card"><h4>Public (1)</h4><p>Approved for external listing APIs and citizen-facing portals.</p></div>
            <div class="wp-data-card"><h4>Private (2)</h4><p>Restricted to authenticated staff within the deploying organization.</p></div>
            <div class="wp-data-card"><h4>Confidential (3)</h4><p>Highest restriction for sensitive personnel, legal, or fiscal records.</p></div>
        </div>
        <h3>Document types and metadata</h3>
        <p>
            Document type codes, tags, and <code>doc_date</code> support filtering by period, category, and subject
            matter. Deployments configure type enums to match their domain—legislative records, tax documents,
            registry certificates, permit files, or corporate policies—without changing core platform code.
        </p>
        <h3>Release channels</h3>
        <ul>
            <li>Staff retrieval through Document Finder and permission-controlled downloads.</li>
            <li>Partner systems via OAuth-protected <code>GET /api/documents</code> with year, month, type, and tag filters.</li>
            <li>Approved public listings via <code>GET /api/getdocuments</code> for integrated portals.</li>
            <li>Direct file delivery via <code>GET /storage/{folder_id}/{filename}</code> when configured for external consumption.</li>
        </ul>
    </section>

    <section id="section-6">
        <h2>6. API and system integrations</h2>
        <p class="section-lead">Connecting DMS to portals, ERP modules, and partner applications</p>
        <ul>
            <li><code>GET /api/documents</code> — OAuth2 protected (Passport client credentials); filter by year, month, type, tags, doc_date.</li>
            <li><code>GET /api/getdocuments</code> — paginated public listing for approved downstream consumers.</li>
            <li><code>GET /api/getdocuments/{id}</code> — single document retrieval with related location and file metadata.</li>
            <li><code>PUT /api/documents/{document}/permission</code> — authenticated permission updates from admin workflows.</li>
            <li>Passport setup: <code>php artisan passport:client --client</code> then <code>POST /oauth/token</code> with <code>client_credentials</code>.</li>
        </ul>
        <p>
            Typical integrations include citizen service portals, legislative information systems, tax and permit
            front-ends, audit exports, and internal dashboards—each scoped by access level and API contract.
        </p>
        @if($lisUrl || $cmsUrl)
        <p class="wp-cross-links">
            Optional ecosystem documentation:
            @if($lisUrl)<a href="{{ $lisUrl }}/whitepaper">LIS White Paper</a>@endif
            @if($lisUrl && $cmsUrl) · @endif
            @if($cmsUrl)<a href="{{ $cmsUrl }}/whitepaper">CMS White Paper</a>@endif
        </p>
        @endif
    </section>

    <section id="section-7">
        <h2>7. System architecture</h2>
        <p class="section-lead">Application and data structure</p>
        <h3>Presentation layer</h3>
        <p>Blade admin UI for document management, document finder, folder and location administration, and user profiles.</p>
        <h3>Application layer</h3>
        <p>Controllers, DocumentService, FileService, StorageResolver, and API layer for external consumption.</p>
        <h3>Data layer</h3>
        <p>Documents, files, folders, organizational entities, users, and file history linked by location and access policy.</p>
        <div class="wp-arch-grid">
            <div class="wp-arch-item">Branch</div>
            <div class="wp-arch-item">Department</div>
            <div class="wp-arch-item">Division</div>
            <div class="wp-arch-item">Section</div>
            <div class="wp-arch-item">Folder</div>
            <div class="wp-arch-item">Document / File</div>
            <div class="wp-arch-item">File history</div>
            <div class="wp-arch-item">API consumers</div>
        </div>
        <h3>Storage</h3>
        <p>Local disk with optional AWS S3 support per deployment—suitable for on-prem LGU hosting or cloud-backed enterprise storage.</p>
    </section>

    <section id="section-8">
        <h2>8. Security and access controls</h2>
        <p class="section-lead">Governance, permissions, and integration integrity</p>
        <ul>
            <li>Laravel UI authentication for web administration modules.</li>
            <li>Laravel Passport for OAuth2 client credentials on protected API routes.</li>
            <li>Per-document permission updates via authenticated web API.</li>
            <li>Three-tier access model enforced before public API or file-serving exposure.</li>
            <li>Department-scoped folders reduce cross-unit data exposure within large organizations.</li>
            <li>CSRF protection on web forms; API routes follow token-based access for machine clients.</li>
        </ul>
    </section>

    <section id="section-9">
        <h2>9. Risk management framework</h2>
        <p class="section-lead">Operational, security, and disclosure risk controls</p>
        <h3>Operational risk</h3>
        <p>Mitigated through folder hierarchy, file history, and centralized search instead of scattered departmental drives.</p>
        <h3>Access risk</h3>
        <p>Least-privilege access levels and staff authentication limit exposure of confidential personnel, fiscal, and legal records.</p>
        <h3>Disclosure risk</h3>
        <p>Public release requires explicit public access classification; API listings respect deployment policy filters.</p>
        <h3>Integration risk</h3>
        <p>OAuth credential rotation, structured API logging, and documented contracts for each consuming system.</p>
    </section>

    <section id="section-10">
        <h2>10. Operational resilience</h2>
        <p class="section-lead">Continuity during disruptions</p>
        <p>
            Organizational continuity depends on reliable storage, accurate metadata, and API availability for
            dependent portals and back-office systems. DMS supports recovery through database backups, storage
            replication (including optional S3), file history, and manual onsite retrieval when integrations are offline.
        </p>
        <p>
            Incident response should follow: detect (logs/alerts), classify severity, contain (disable affected API
            client or release channel), restore storage and database services, reconcile released documents against
            access policies, and document root cause for governance review.
        </p>
    </section>

    <section id="section-11">
        <h2>11. Platform role summary</h2>
        <p class="section-lead">Document management positioning in one view</p>
        <h3>DMS, in summary</h3>
        <ul>
            <li>Unified document management for LGU departments and private organizational units on one platform.</li>
            <li>Tracks records from intake through classification, custody, and authorized release.</li>
            <li>Maps treasury, taxes, civil registry, permits, and corporate functions into a shared hierarchy model.</li>
            <li>Exposes OAuth and listing APIs for portals, ERP modules, and partner systems—not a single vertical only.</li>
            <li>White-label ready for government and non-government deployments without per-client code forks.</li>
        </ul>
    </section>
@endsection

@section('cta')
    <h2>Ready to evaluate DMS for your organization?</h2>
    <p>Prepare department structure, document types, access policies, and integration requirements for a rollout design workshop.</p>
    <div class="wp-cta-buttons">
        <a href="{{ $loginRoute }}" class="btn-primary-wp">{{ $loginLabel }}</a>
        <a href="{{ route('whitepaper') }}" class="btn-outline-wp">Back to white paper</a>
    </div>
@endsection
