<script setup>
    import { inject } from 'vue';

    // Inject dữ liệu cần thiết
    const portfolioData = inject('portfolioData');
</script>

<template>
    <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🛠️ Bộ Kỹ Năng</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <h3 class="fs-5 fw-semibold mb-3 text-primary">🔧 Kỹ năng cứng (Hard Skills)</h3>
                <div class="d-flex flex-column gap-3">
                    <div v-for="skill in portfolioData.personal.hardSkills" :key="skill" class="bg-light p-3 rounded-2 d-flex justify-content-between align-items-left">
                        <span class="fw-medium text-dark">{{ skill }}</span>
                        <div class="progress w-50" role="progressbar" aria-label="Skill level" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-info" :style="{width: (Math.random() * 30 + 70) + '%'}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="fs-5 fw-semibold mb-3 text-success">✨ Kỹ năng mềm (Soft Skills)</h3>
                <div class="d-flex flex-wrap gap-2">
                    <span v-for="skill in portfolioData.personal.softSkills" :key="skill" class="badge bg-success-subtle text-success-emphasis fs-6 px-3 py-2 rounded-pill shadow-sm transition transform-hover-scale">
                        {{ skill }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* CSS đặc thù cho phần kỹ năng */
.transition {
    transition: all 0.3s ease-in-out;
}
.transform-hover-scale {
    transition: transform 0.3s ease-in-out;
}
.transform-hover-scale:hover {
    transform: scale(1.03);
}
</style>