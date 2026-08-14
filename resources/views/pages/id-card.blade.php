@extends('layouts.app')

@section('title', 'My Digital ID Card')
@section('page-title', 'My Digital ID Card')

@push('styles')
<style>
.id-card-page{padding:28px 12px 45px}.id-card-toolbar{max-width:960px;margin:0 auto 18px;display:flex;justify-content:space-between;align-items:center;gap:16px}.id-card-toolbar p{margin:0;color:#6b7280}.employee-card-shell{max-width:960px;margin:auto}.employee-card{position:relative;isolation:isolate;overflow:hidden;width:100%;aspect-ratio:3/2;background:#fff;border:2px solid #075324;border-radius:26px;box-shadow:0 18px 45px rgba(6,60,29,.18);color:#111;font-family:Arial,sans-serif}.employee-card:before{content:"";position:absolute;z-index:-1;right:-9%;top:-27%;width:39%;height:52%;border-radius:0 0 0 100%;background:#075324;border-left:10px solid #d3a525;transform:rotate(5deg)}.employee-card:after{content:"";position:absolute;z-index:-1;left:-5%;right:-5%;bottom:-12%;height:28%;background:#075324;border-top:9px solid #d3a525;border-radius:50% 50% 0 0/25% 25% 0 0}.card-header-area{height:25%;display:flex;align-items:center;padding:2.7% 5.5% 1%;gap:3.5%}.card-logo{width:18%;height:100%;object-fit:contain}.company-copy{flex:1;min-width:0;text-align:center;padding-right:5%}.company-copy h1{font-size:clamp(20px,3.25vw,39px);line-height:1.05;margin:0;color:#075324;font-weight:900;letter-spacing:.2px;white-space:nowrap}.company-copy .gold-rule{height:2px;background:linear-gradient(90deg,transparent,#d3a525 18%,#d3a525 82%,transparent);margin:3% auto 1.5%;width:88%}.company-copy p{font-size:clamp(12px,1.7vw,21px);margin:0;color:#075324}.card-main{height:58%;display:grid;grid-template-columns:29% 1fr;gap:5%;padding:1% 6% 1.5%}.photo-frame{height:90%;align-self:center;border:3px solid #075324;border-radius:19px;overflow:hidden;background:#eef3ef}.photo-frame img{width:100%;height:100%;object-fit:cover;display:block}.card-details{align-self:start;padding-top:0;min-width:0}.digital-label{display:inline-block;background:#075324;color:#fff;border-radius:14px;padding:1% 7%;font-size:clamp(12px,1.75vw,21px);font-weight:800;letter-spacing:.35px}.employee-name{font-size:clamp(21px,3.35vw,40px);line-height:1.08;color:#075324;font-weight:900;margin:2.5% 0 2%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.identity-line{display:grid;grid-template-columns:30% 4% 1fr;align-items:center;font-size:clamp(12px,1.65vw,20px);line-height:1.4}.identity-line strong{color:#075324}.details-divider{border:0;border-top:3px solid #d3a525;opacity:1;margin:2.2% 0}.meta-line{display:grid;grid-template-columns:7% 29% 4% 1fr;align-items:center;font-size:clamp(11px,1.45vw,18px);line-height:1.52}.meta-icon{color:#fff;background:#075324;border-radius:6px;width:72%;aspect-ratio:1;display:grid;place-items:center;font-size:.66em}.status-active{font-weight:800;color:#087c38}.card-footer{position:absolute;z-index:2;left:0;right:0;bottom:0;height:16%;display:flex;align-items:center;justify-content:center;gap:3%;padding:3.3% 4.5% .8%;color:#fff;font-size:clamp(10px,1.35vw,17px)}.contact-item{display:flex;align-items:center;gap:8px;white-space:nowrap}.contact-item i{background:#fff;color:#075324;border-radius:50%;width:2em;height:2em;display:grid;place-items:center}.contact-separator{width:1px;height:38%;background:rgba(255,255,255,.7)}.download-card-btn{border:0;background:#075324;color:#fff;border-radius:999px;font-weight:800;padding:12px 22px;box-shadow:0 8px 18px rgba(7,83,36,.2)}.download-card-btn:hover{background:#053d1b}.download-card-btn:disabled{opacity:.65}.print-note{display:none}@media(max-width:700px){.id-card-page{padding:18px 0}.id-card-toolbar{align-items:flex-start;flex-direction:column}.employee-card{border-radius:16px}.card-main{grid-template-columns:31% 1fr}.photo-frame{border-width:2px;border-radius:12px}.employee-name{margin-top:3%}.card-footer{gap:2%}.contact-item i{display:none}}@media print{body *{visibility:hidden}.employee-card-shell,.employee-card-shell *{visibility:visible}.employee-card-shell{position:absolute;inset:0;width:100%;max-width:none}.employee-card{box-shadow:none}.sidebar,.topbar,.id-card-toolbar{display:none!important}}
/* Keep the full preview inside the dashboard viewport. Typography follows the card, not the browser width. */
.employee-card-shell{
    width:min(100%, 900px, calc((100vh - 230px) * 1.5));
}
.employee-card{
    container-type:inline-size;
    border-radius:22px;
}
.employee-card:before{
    right:-10%;
    top:-31%;
    width:34%;
    height:50%;
    border-left-width:7px;
}
.card-header-area{
    height:24%;
    padding:2.4% 5% .7%;
    gap:3%;
}
.card-logo{width:17%}
.company-copy{padding-right:2%}
.company-copy h1{font-size:4.05cqw}
.company-copy p{font-size:2.2cqw}
.card-main{
    height:59%;
    grid-template-columns:29% 1fr;
    gap:5%;
    padding:.8% 6% 1.5%;
}
.photo-frame{height:89%;border-radius:15px}
.digital-label{font-size:2.2cqw;border-radius:11px}
.employee-name{font-size:4.2cqw;margin:2.2% 0 1.5%}
.identity-line{font-size:2.05cqw;line-height:1.38}
.details-divider{margin:2% 0}
.meta-line{font-size:1.78cqw;line-height:1.5}
.card-footer{height:16%;font-size:1.7cqw;gap:2.7%}
@media(max-width:700px){
    .employee-card-shell{width:100%}
}
</style>
@endpush

@section('content')
@php
    $photoUrl = !empty($profile?->profile_photo) ? asset($profile->profile_photo) : asset('images/profile-placeholder.svg');
    $memberStatus = $user->status ?: 'Inactive';
@endphp
<div class="id-card-page">
    <div class="id-card-toolbar">
        <div><h4 class="fw-bold mb-1">Employee Digital ID Card</h4><p>Your card is generated from your current profile information.</p></div>
        <button type="button" class="download-card-btn" id="downloadIdCard"><i class="fa-solid fa-download me-2"></i>Download ID Card</button>
    </div>

    <div class="employee-card-shell">
        <div class="employee-card" id="employeeIdCard">
            <div class="card-header-area">
                <img class="card-logo" src="{{ asset('images/arm-ayurveda-logo.png') }}" alt="ARM Ayurveda logo">
                <div class="company-copy"><h1>ARM AYURVEDA PVT. LTD.</h1><div class="gold-rule"></div><p>Empowering Lives Naturally</p></div>
            </div>
            <div class="card-main">
                <div class="photo-frame"><img src="{{ $photoUrl }}" onerror="this.onerror=null;this.src='{{ asset('images/profile-placeholder.svg') }}';" alt="{{ $user->name }}"></div>
                <div class="card-details">
                    <span class="digital-label">DIGITAL ID CARD</span>
                    <div class="employee-name">{{ $user->name }}</div>
                    <div class="identity-line"><span>Member ID</span><span>:</span><strong>{{ $user->member_id ?: 'N/A' }}</strong></div>
                    <div class="identity-line"><span>Sponsor ID</span><span>:</span><strong>{{ $user->sponsor_id ?: 'N/A' }}</strong></div>
                    <hr class="details-divider">
                    <div class="meta-line"><span class="meta-icon"><i class="fa-regular fa-calendar"></i></span><span>Joined Date</span><span>:</span><span>{{ optional($user->created_at)->format('d M Y') ?: '-' }}</span></div>
                    <div class="meta-line"><span class="meta-icon"><i class="fa-solid fa-box-open"></i></span><span>Package</span><span>:</span><span>{{ $user->package_name ?: 'No Package' }}</span></div>
                    <div class="meta-line"><span class="meta-icon"><i class="fa-solid fa-shield-halved"></i></span><span>Status</span><span>:</span><span class="{{ strtolower($memberStatus) === 'active' ? 'status-active' : 'fw-bold text-danger' }}">{{ $memberStatus }}</span></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="contact-item"><i class="fa-solid fa-phone"></i><span>+91 8759670380</span></div><span class="contact-separator"></span>
                <div class="contact-item"><i class="fa-solid fa-envelope"></i><span>arm+3@gmail.com</span></div><span class="contact-separator"></span>
                <div class="contact-item"><i class="fa-solid fa-globe"></i><span>www.armayurveda.com</span></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
document.getElementById('downloadIdCard').addEventListener('click', async function () {
    const button = this;
    const original = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Preparing...';
    try {
        if (typeof html2canvas !== 'function') throw new Error('Image generator unavailable');
        const card = document.getElementById('employeeIdCard');
        const exportWidth = 1500;
        const canvas = await html2canvas(card, {
            scale: exportWidth / card.offsetWidth,
            useCORS: true,
            backgroundColor: '#ffffff',
            logging: false
        });
        const link = document.createElement('a');
        link.download = @json(($user->member_id ?: 'ARM') . '-digital-id-card.png');
        link.href = canvas.toDataURL('image/png');
        link.click();
    } catch (error) {
        toastr.error('The image could not be created. Please refresh the page and try again.');
    } finally {
        button.disabled = false;
        button.innerHTML = original;
    }
});
</script>
@endpush
