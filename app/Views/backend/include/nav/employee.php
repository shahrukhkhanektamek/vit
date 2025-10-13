<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('admin.dashboard'))?>">
        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link menu-link" href="#managePartner" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="managePartner">
        <i class="ri-contacts-line"></i> <span data-key="t-dashboards">Manage Partner</span>
    </a>
    <div class="collapse menu-dropdown" id="managePartner">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="<?=base_url(route_to('admin-user.list')).'?type=3'?>" class="nav-link" data-key="t-analytics"> Advocates </a>
            </li>
            <li class="nav-item">
                <a href="<?=base_url(route_to('admin-user.list')).'?type=4'?>" class="nav-link" data-key="t-analytics"> CA </a>
            </li>
            <li class="nav-item">
                <a href="<?=base_url(route_to('admin-user.list')).'?type=5'?>" class="nav-link" data-key="t-analytics"> Advisers </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link menu-link" href="#manageuser" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="manageuser">
        <i class="ri-contacts-line"></i> <span data-key="t-dashboards">Manage User</span>
    </a>
    <div class="collapse menu-dropdown" id="manageuser">
        <ul class="nav nav-sm flex-column">

            <li class="nav-item">
                <a href="<?=base_url(route_to('admin-user.list')).'?type=2'?>" class="nav-link" data-key="t-analytics"> Users </a>
            </li>

        </ul>
    </div>
</li>



<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('lead-enquiry.list'))?>">
        <i class="ri-wallet-line"></i> <span data-key="t-transaction">Leads</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('kyc.list'))?>">
        <i class="ri-wallet-line"></i> <span data-key="t-transaction">Kyc</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link menu-link" href="#services" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="services">
        <i class="ri-message-2-line"></i> <span data-key="t-dashboards">Services</span>
    </a>
    <div class="collapse menu-dropdown" id="services">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="<?=base_url(route_to('service-category.list'))?>" class="nav-link" data-key="t-analytics">Category </a>
            </li>
            <li class="nav-item">
                <a href="<?=base_url(route_to('service.list'))?>" class="nav-link" data-key="t-analytics"> Service </a>
            </li>
        </ul>
    </div>
</li>



<li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">AI Assistance</span></li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url().'gemini/' ?>ask-ally">
        <i class="ri-robot-line"></i>
        <span>Ask Ally</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url().'gemini/' ?>legal-research">
        <i class="ri-scales-line"></i>
        <span>Legal Research</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url().'gemini/' ?>translator">
        <i class="ri-translate"></i>
        <span>Translator</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url().'gemini/' ?>complaint-writer">
        <i class="ri-pen-nib-line"></i>
        <span>Complaint Writer</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url().'gemini/' ?>document-generator">
        <i class="ri-file-line"></i>
        <span>Document Generator</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url().'gemini/' ?>document-analyzer">
        <i class="ri-search-line"></i>
        <span>Document Analyzer</span>
    </a>
</li>













<li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Manage Other</span></li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('country.list'))?>">
        <i class="ri-image-line"></i> <span data-key="t-transaction">Country</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('state.list'))?>">
        <i class="ri-image-line"></i> <span data-key="t-transaction">State</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('education.list'))?>">
        <i class="ri-image-line"></i> <span data-key="t-transaction">Education</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link menu-link" href="<?=base_url(route_to('certification.list'))?>">
        <i class="ri-image-line"></i> <span data-key="t-transaction">Certification</span>
    </a>
</li>




<li class="nav-item">
    <a class="nav-link menu-link" href="#blog" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="blog">
        <i class="ri-newspaper-line"></i> <span data-key="t-dashboards">Manage Blog</span>
    </a>
    <div class="collapse menu-dropdown" id="blog">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="<?=base_url(route_to('blog-category.list'))?>" class="nav-link" data-key="t-analytics"> Category </a>
            </li>
            <li class="nav-item">
                <a href="<?=base_url(route_to('blog.list'))?>" class="nav-link" data-key="t-analytics"> Blog/News </a>
            </li>
        </ul>
    </div>
</li>




