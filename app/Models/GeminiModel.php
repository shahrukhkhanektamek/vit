<?php

namespace App\Models; // Assuming your models are in the App\Models namespace

use CodeIgniter\Model;
use Exception;

// For simplicity, defining types as PHP array structures within comments.
// In a real CodeIgniter 4 app, you might use more formal DTOs or entities.

/**
 * Represents a section of legal text.
 * @typedef array{title: string, content: string} Section
 */

/**
 * Represents a legal case.
 * @typedef array{caseNumber: string, courtName: string, clientName: string, opponentName: string, caseType: string, status: string, notes: string} Case
 */

/**
 * Represents a CRM ticket.
 * @typedef array{subject: string, body: string, fromName: string, fromEmail: string, type: string} CrmTicket
 */

/**
 * Represents an LLM analysis result.
 * @typedef array{summary: string, priority: string, recommendedAssignee: array{name: string, role: string}, justification: string} LlmAnalysis
 */

/**
 * Represents a WhatsApp message.
 * @typedef array{author: string, text: string} WhatsAppMessage
 */

/**
 * Represents a user security profile.
 * @typedef array{userId: string, username: string, lastPasswordChange: string, twoFactorEnabled: bool, loginHistory: array<array{timestamp: string, ipAddress: string, successful: bool}>} UserSecurityProfile
 */

/**
 * Represents a security recommendation.
 * @typedef array{id: string, text: string, priority: string} SecurityRecommendation
 */

/**
 * Represents a legal research query.
 * @typedef array{query: string, jurisdiction: string, type: string} LegalResearchQuery
 */

/**
 * Represents a legal research result.
 * @typedef array{summary: string, responseText: string, sources: array<array{uri: string, title: string}>} LegalResearchResult
 */

/**
 * Represents a live news item.
 * @typedef array{title: string, summary: string, uri: string, imageUrl: string, source: string, published: string, videoUrl: string} LiveNewsItem
 */


/**
 * A simplified class to simulate Google GenAI API interactions using cURL.
 * In a real-world application, you would typically place this in app/Libraries/ or use a dedicated Composer package.
 */
class GeminiClient
{
    private string $apiKey;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct(string $apiKey)
    {
        if (empty($apiKey)) {
            throw new Exception("API_KEY environment variable not set or empty.");
        }
        $this->apiKey = $apiKey;
    }

    /**
     * Simulates the generateContent API call.
     * @param string $model
     * @param array $contents
     * @param array $config
     * @return string Raw response text from the API.
     * @throws Exception if cURL request fails or returns an error.
     */
    public function generateContent(string $model, array $contents, array $config = []): string
    {
        $url = $this->baseUrl . $model . ':generateContent?key=' . $this->apiKey;

        $payload = [
            'contents' => $contents,
        ];

        if (isset($config['generationConfig'])) {
            $payload['generationConfig'] = $config['generationConfig'];
        }
        if (isset($config['safetySettings'])) {
            $payload['safetySettings'] = $config['safetySettings'];
        }
        if (isset($config['tools'])) {
            $payload['tools'] = $config['tools'];
        }

        $jsonPayload = json_encode($payload);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Keep this true for production

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL Error: " . $error_msg);
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code >= 400) {
            error_log("API Error Response (HTTP {$http_code}): " . $response);
            throw new Exception("API request failed with status code " . $http_code . ". Response: " . $response);
        }

        $responseData = json_decode($response, true);
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        } elseif (isset($responseData['error']['message'])) {
             throw new Exception("Gemini API Error: " . $responseData['error']['message']);
        }
        return $response; // Return raw response if text not directly found, might be JSON for tools etc.
    }
}

class GeminiModel extends Model
{
    protected $table      = null; // No direct database table for this model as it's an API wrapper
    protected $primaryKey = null;

    protected $returnType    = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = []; // No fields as it's not storing data

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * @var GeminiClient The Gemini API client instance.
     */
    protected GeminiClient $ai;

    /**
     * @var array Simulating the PERSONNEL constant from the original code.
     * In a real CI4 app, this would be in app/Config/Constants.php or a dedicated config file.
     */
    protected array $personnel = [
        ['Dr. Raj Sharma', 'Admin', ['overall management', 'strategic planning']],
        ['Priya Singh', 'Legal Consultant (Corporate)', ['company law', 'M&A', 'startups', 'IP registration']],
        ['Amit Gupta', 'Legal Consultant (Litigation)', ['civil disputes', 'criminal defense', 'consumer cases']],
        ['Sneha Reddy', 'Tax Consultant (GST & Income Tax)', ['GST compliance', 'income tax filing', 'tax planning', 'audits']],
        ['Vikram Desai', 'Compliance Officer', ['regulatory compliance', 'licensing', 'policy drafting']],
        ['Geeta Rao', 'Client Relations Manager', ['client onboarding', 'query resolution', 'feedback management']],
        ['Rahul Verma', 'Paralegal', ['document preparation', 'legal research support', 'case tracking']],
        ['Anjali Sharma', 'HR Manager', ['human resources', 'internal policies', 'recruitment']],
        ['Suresh Kumar', 'IT Support', ['technical issues', 'system maintenance', 'cybersecurity']],
        ['Deepak Singh', 'Marketing Specialist', ['digital marketing', 'brand promotion', 'lead generation']]
    ];

    public function __construct()
    {
        parent::__construct();

        // Load the API Key from .env or config file
        $apiKey = getenv('GEMINI_API_KEY') ?: $_ENV['GEMINI_API_KEY'] ?? config('App')->geminiApiKey ?? null;

        if (!$apiKey) {
            // IMPORTANT: For local testing, you might hardcode it here TEMPORARILY.
            // DO NOT commit your API key to version control!
            $apiKey = 'YOUR_GEMINI_API_KEY_HERE';
            if ($apiKey === 'YOUR_GEMINI_API_KEY_HERE') {
                 log_message('warning', 'GEMINI_API_KEY environment variable not set. Using placeholder API key. Please set it securely in .env or Config/App.php.');
            }
        }

        $this->ai = new GeminiClient($apiKey);
    }

    /**
     * Provides a concise explanation of a legal section based on a user query.
     * @param Section $section
     * @param string $userQuery
     * @return string
     */
    public function getLegalExplanation(array $section, string $userQuery): string
    {
        try {
            $prompt = "
                System Instruction: You are \"Ally legal assistance\", an expert legal assistant specializing in the Indian legal framework. Your role is to provide clear, accurate, and easy-to-understand explanations of legal sections. Do not provide legal advice or opinions. Your response must be strictly based on the provided legal text and the user's question.

                Legal Text to analyze:
                ---
                Act: " . explode(':', $section['title'])[0] . "
                Section: " . $section['title'] . "
                Content: \"" . $section['content'] . "\"
                ---

                User's Question:
                ---
                " . $userQuery . "
                ---

                Based ONLY on the legal text provided above, provide a concise and direct explanation in response to the user's question. Start your response directly without any preamble like \"Based on the text provided...\".
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error fetching explanation from Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Generates a formal legal document.
     * @param string $docType
     * @param string $userDetails
     * @return string
     */
    public function generateLegalDocument(string $docType, string $userDetails): string
    {
        try {
            $prompt = "
                System Instruction: You are \"Ally legal assistance\", an expert legal assistant specializing in drafting documents for the Indian legal system. Your role is to generate a formal, well-structured legal document based on the user's request.

                **CRITICAL INSTRUCTIONS:**
                1.  **Do not provide legal advice, opinions, or any commentary.** Your output must be ONLY the generated document text.
                2.  The document must be formatted professionally for the Indian legal context, with appropriate headings, and placeholders like \"[Your Name]\", \"[Address]\", \"[Date]\", \"[Name of the Court]\", etc., where the user needs to fill in personal details.
                3.  Begin the document directly. Do not include any preambles like \"Here is the draft...\".
                4.  Conclude the document with a clear, mandatory disclaimer on a new line, separated by '---'. The disclaimer must state: \"---
**Disclaimer:** This document is AI-generated and for informational purposes only. It is not a substitute for professional legal advice. Consult with a qualified legal professional before using this document.\"

                ---
                Document Type to Generate:
                " . $docType . "
                ---
                User-provided Details:
                \"" . $userDetails . "\"
                ---

                Generate the " . $docType . " based on the details provided.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error generating document from Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Generates a formal legal complaint.
     * @param array $details
     * @return string
     */
    public function generateComplaint(array $details): string
    {
        try {
            $prompt = "
                System Instruction: You are \"Ally legal assistance\", an expert legal assistant specializing in drafting formal complaints for the Indian legal system. Your role is to generate a formal, well-structured legal complaint based on the user's structured input.

                **CRITICAL INSTRUCTIONS:**
                1.  **Do not provide legal advice, opinions, or any commentary.** Your output must be ONLY the generated complaint text.
                2.  The complaint must be formatted professionally for submission to a police station in India. It should include:
                    -   A proper \"To\" address using the provided Jurisdiction details (e.g., To, The Station House Officer, {$details['policeStation']}, {$details['district']}, {$details['state']}).
                    -   A clear \"Subject\" line.
                    -   Sections for Complainant's details and Accused's details.
                    -   A detailed \"Statement of Facts\" based on the incident description.
                    -   A \"Prayer\" clause requesting appropriate action (e.g., registration of an FIR).
                    -   A concluding section for the complainant's signature.
                3.  Use the provided details to populate the document. Where details are missing, use standard placeholders (e.g., \"[Applicable Law Sections]\").
                4.  Begin the document directly. Do not include any preambles like \"Here is the draft complaint...\".
                5.  Conclude the document with a clear, mandatory disclaimer on a new line, separated by '---'. The disclaimer must state: \"---
**Disclaimer:** This document is AI-generated and for informational purposes only. It is not a substitute for professional legal advice. Consult with a qualified legal professional before using this document.\"

                ---
                **COMPLAINT DETAILS PROVIDED BY USER:**
                ---
                **Jurisdiction:**
                State: {$details['state']}
                District: {$details['district']}
                Police Station: {$details['policeStation']}

                **Complainant:**
                Name: {$details['complainantName']}
                Address: {$details['complainantAddress']}

                **Accused/Opposite Party:**
                Name: {$details['accusedName']}
                Address: {$details['accusedAddress']}

                **Incident Details:**
                Date of Incident: {$details['incidentDate']}
                Location of Incident: {$details['incidentLocation']}
                Description of Incident:
                \"" . $details['incidentDescription'] . "\"
                ---

                Generate the formal legal complaint based on these structured details.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error generating complaint from Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Analyzes a legal document.
     * @param string $documentText
     * @return string
     */
    public function analyzeLegalDocument(string $documentText): string
    {
        try {
            $prompt = "
                System Instruction: You are \"Ally legal assistance\", an expert legal assistant specializing in analyzing legal documents from the Indian legal framework. Your task is to provide a structured, clear, and concise analysis of the provided document text.

                **CRITICAL INSTRUCTIONS:**
                1.  **Do not provide legal advice or opinions.** Your analysis must be objective and based solely on the text.
                2.  Format your response clearly with the following sections, using Markdown for headings:
                    -   **### Document Summary:** Provide a brief, neutral summary of the document's purpose and key contents.
                    -   **### Key Information Extracted:** Use bullet points to list critical pieces of information (e.g., names of parties, dates, locations, case numbers, specific allegations or requests).
                    -   **### Potential Next Steps (General Information):** Suggest general, non-advisory next steps someone might take after receiving or drafting such a document. Frame these as possibilities, not instructions (e.g., \"One might consider...\", \"A possible next step could be...\").
                3.  **Mandatory Disclaimer:** Conclude the entire response with a clear, mandatory disclaimer on a new line, separated by '---'. The disclaimer must state: \"---
**Disclaimer:** This analysis is AI-generated and for informational purposes only. It is not a substitute for professional legal advice. Consult with a qualified legal professional for guidance on your specific situation.\"

                ---
                **DOCUMENT TEXT FOR ANALYSIS:**
                ---
                " . $documentText . "
                ---

                Provide your structured analysis based on the text provided.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error analyzing document with Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Gets legal news based on a query.
     * Note: This function would typically require a Google Search API integration,
     * which is not directly part of the Gemini API. A placeholder will be used.
     * @param string $query
     * @return LiveNewsItem[]
     */
    public function getLegalNews(string $query): array
    {
        try {
            $prompt = "
                System Instruction: You are an expert news aggregator AI for a legal tech platform. Your task is to find live, relevant news based on a query and return it as a structured JSON array.

                **CRITICAL INSTRUCTIONS:**
                1.  **Use Google Search:** Use the provided search tool to find the most recent and relevant news articles for the user's query. The news should be from free, public sources.
                2.  **Return JSON Array:** Your entire response MUST be a single, valid JSON array of objects. Do not include any text outside of the JSON array. Do not wrap it in a markdown block.
                3.  **JSON Object Structure:** Each object in the array must have the following keys:
                    -   `title`: The full, original title of the news article.
                    -   `summary`: A brief, one or two-sentence summary of the article.
                    -   `uri`: The direct URL to the original news article.
                    -   `imageUrl`: A direct URL to a relevant, high-quality image for the article. This should be a full URL ending in .jpg, .png, .webp, etc. Find a visually compelling image. If none is found, use a generic relevant image URL (e.g., from unsplash, pexels).
                    -   `source`: The name of the news publication (e.g., \"The Hindu\", \"LiveLaw\", \"Bar & Bench\").
                    -   `published`: The relative time of publication (e.g., \"2 hours ago\", \"1 day ago\").
                    -   `videoUrl`: If the article is primarily a video (e.g., on YouTube), provide the direct embeddable URL for the video. Otherwise, this should be an empty string.
                4.  **Content Requirements:**
                    -   Provide 5-7 news items.
                    -   Ensure diversity in sources if possible.
                    -   Prioritize news from reputable Indian legal and general news outlets.

                ---
                **User's News Query:**
                ---
                \"" . $query . "\"
                ---

                Generate the JSON array response.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]],
                ['tools' => [['googleSearch' => (object)[]]]] // Simulate tool usage config
            );

            $jsonStr = trim($response);
            // Remove markdown fence if present
            $jsonStr = preg_replace('/^```(?:json)?\s*\n?(.*?)\n?\s*```$/s', '$1', $jsonStr);
            $jsonStr = trim($jsonStr);

            return json_decode($jsonStr, true) ?: [];

        } catch (Exception $e) {
            log_message('error', "Error fetching or parsing legal news from Gemini API: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Analyzes case strategy.
     * @param Case $caseDetails
     * @return string
     */
    public function analyzeCaseStrategy(array $caseDetails): string
    {
        try {
            $prompt = "
                System Instruction: You are \"Ally legal assistance\", an expert legal strategy analyst for the Indian legal system. Your role is to provide a neutral, structured analysis of a legal case based on the provided details.

                **CRITICAL INSTRUCTIONS:**
                1.  **Do not provide definitive legal advice or guarantee outcomes.** Your analysis must be framed as a strategic overview based on the information given.
                2.  Format your response clearly with the following sections, using Markdown for headings:
                    -   **### Case Overview:** Briefly summarize the case details provided.
                    -   **### Potential Strengths:** Based on the details, list potential strengths for the client's position.
                    -   **### Potential Risks/Weaknesses:** List potential risks or weaknesses that may need to be addressed.
                    -   **### Suggested Strategic Considerations:** Offer general strategic points to consider. Examples: \"Focus on procedural compliance,\" \"Explore settlement options,\" \"Gather further evidence related to...\"
                    -   **### Potentially Relevant Legal Areas:** List broad legal acts or sections that might be relevant for research (e.g., \"Contract Act, 1872,\" \"Specific Relief Act,\" \"Code of Civil Procedure sections on jurisdiction\").
                3.  **Mandatory Disclaimer:** Conclude the entire response with a clear, mandatory disclaimer on a new line, separated by '---'. The disclaimer must state: \"---
**Disclaimer:** This analysis is AI-generated and for strategic informational purposes only. It is not a substitute for professional legal advice from a qualified advocate who has reviewed the entire case file. Case outcomes depend on numerous factors not detailed here.\"

                ---
                **CASE DETAILS FOR ANALYSIS:**
                ---
                Case Number: {$caseDetails['caseNumber']}
                Court: {$caseDetails['courtName']}
                Parties: {$caseDetails['clientName']} (Client) vs {$caseDetails['opponentName']}
                Case Type: {$caseDetails['caseType']}
                Current Status: {$caseDetails['status']}
                Case Notes: \"" . $caseDetails['notes'] . "\"
                ---

                Provide your structured strategic analysis based on these case details.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error analyzing case with Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Translates a legal document.
     * @param string $text
     * @param string $targetLanguage
     * @return string
     */
    public function translateDocument(string $text, string $targetLanguage): string
    {
        try {
            $prompt = "
                System Instruction: You are an expert legal translator. Your task is to translate the provided legal text into the specified target language.

                **CRITICAL INSTRUCTIONS:**
                1.  **Target Language:** " . $targetLanguage . "
                2.  **Maintain Tone and Terminology:** The translation must preserve the formal tone and specific legal terminology of the original document. Do not simplify or paraphrase.
                3.  **Preserve Formatting:** Maintain the original structure, including paragraphs, line breaks, and numbering.
                4.  **Output ONLY Translated Text:** Your response must contain ONLY the translated text. Do not include any preambles, apologies, explanations, or disclaimers like \"Here is the translation...\".

                ---
                **LEGAL TEXT TO TRANSLATE:**
                ---
                " . $text . "
                ---
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error translating document with Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your translation request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Gets a conversational response from Ally AI.
     * @param string $query
     * @param string $context
     * @return string
     */
    public function getAllyResponse(string $query, string $context): string
    {
        try {
            // Assuming context is already a JSON string that needs to be directly inserted.
            $prompt = "
                System Instruction: You are \"Ally\", an expert AI legal practice assistant integrated into the \"Ally Legal Services\" platform. Your role is to understand and answer questions about the user's practice based on the provided data context. You are conversational, helpful, and insightful.

                **CRITICAL INSTRUCTIONS:**
                1.  **Analyze the User's Query:** Understand the user's intent. They might ask for specific data, summaries, calculations, or insights.
                2.  **Use the Data Context:** Your primary source of truth is the JSON data provided below. All answers must be derived from this data. Do not invent information. If the data is insufficient to answer, state that clearly.
                3.  **Interactive Responses:** When you mention a specific entity from the data (like a client, case, or invoice), you MUST wrap it in a special format for the UI to create a link. Use the format: `[type:value]`.
                    -   For clients: `[client:CLIENT_NAME]` (e.g., `[client:Rohan Verma]`)
                    -   For cases: `[case:CASE_NUMBER]` (e.g., `[case:CS/123/2023]`)
                    -   For invoices: `[invoice:INVOICE_ID]` (e.g., `[invoice:INV-001]`)
                    Example: \"The client [client:Sunita Nair] has an ongoing case [case:CR/456/2024] with an outstanding invoice [invoice:INV-002].\"
                4.  **Be Conversational:** Answer in natural language. Perform calculations if asked (e.g., \"What is the total overdue amount?\").
                5.  **Do Not Output JSON:** Do not repeat the data context in your response. Provide a clean, human-readable answer.

                ---
                **DATA CONTEXT (The user's entire practice data):**
                ---
                " . $context . "
                ---

                **User's Question:**
                ---
                \"" . $query . "\"
                ---

                Generate a helpful, conversational, and interactive response based on the user's question and the provided data context.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error getting response from Ally Hub: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Generates a business registration checklist.
     * @param array $details
     * @return string
     */
    public function generateRegistrationChecklist(array $details): string
    {
        try {
            $prompt = "
                System Instruction: You are an expert corporate services assistant in India. Your task is to generate a detailed checklist of required documents and the typical registration process for a new business entity. Format the output clearly using Markdown with separate sections for \"Documents Required\" and \"Registration Process\".

                **CRITICAL INSTRUCTIONS:**
                1.  Provide information relevant to India.
                2.  The document list should be comprehensive.
                3.  The process steps should be sequential and easy to understand.
                4.  Conclude with a mandatory disclaimer: \"---
**Disclaimer:** This checklist is for informational purposes only and is not legal advice. The process and documents may vary. Consult a qualified professional (CA/CS/Lawyer) for guidance.\"

                ---
                **ENTITY DETAILS:**
                - **Entity Type:** {$details['entityType']}
                - **Business Objective:** {$details['businessObjective']}
                ---

                Generate the checklist based on these details.
            ";
            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );
            return $response;
        } catch (Exception $e) {
            log_message('error', "Error generating registration checklist: " . $e->getMessage());
            return "Failed to generate checklist. Please try again later.";
        }
    }

    /**
     * Gets GST information based on help type and query.
     * @param string $helpType
     * @param string $query
     * @return string
     */
    public function getGstInfo(string $helpType, string $query): string
    {
        try {
            $systemInstruction = "You are \"Ally Tax Assistant\", an expert Indian tax consultant specializing in GST. You provide clear, accurate, and concise information. Conclude every response with a mandatory disclaimer: \"---
**Disclaimer:** This information is AI-generated and for informational purposes only. It is not tax advice. Consult a qualified tax professional for guidance on your specific situation.\"";

            $userPrompt = "";

            switch ($helpType) {
                case 'Find HSN/SAC Code':
                    $userPrompt = "For the following product/service, suggest the most likely HSN (for goods) or SAC (for services) codes applicable in India. Provide a brief justification for each suggestion. Product/Service: \"{$query}\"";
                    break;
                case 'Find GST Rate':
                    $userPrompt = "What is the applicable GST rate (e.g., 0%, 5%, 12%, 18%, 28%) for the following product or service in India? Provide the rate and a short explanation. Product/Service: \"{$query}\"";
                    break;
                case 'Invoice Requirement Checklist':
                    $userPrompt = "Generate a comprehensive checklist of all mandatory fields required on a GST-compliant tax invoice in India. " . ($query ? "Pay special attention to these details if relevant: \"{$query}\"" : '');
                    break;
                case 'General Question':
                default:
                    $userPrompt = "Answer the following question about Indian GST concisely: \"{$query}\"";
                    break;
            }

            $response = $this->ai->generateContent(
                'gemini-2.5-flash',
                [['role' => "user", 'parts' => [['text' => "{$systemInstruction}\n\n{$userPrompt}"]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error fetching GST info from Gemini API: " . $e->getMessage());
            return "I'm sorry, but I encountered an error while processing your request. Please check the logs for details and try again later.";
        }
    }

    /**
     * Analyzes and routes a CRM ticket.
     * @param CrmTicket $ticket
     * @param array $personnelList
     * @return LlmAnalysis
     */
    public function analyzeAndRouteTicket(array $ticket, array $personnelList = []): array
    {
        // Use the model's internal personnel list if not provided externally
        if (empty($personnelList)) {
            $personnelList = $this->personnel;
        }

        try {
            $prompt = "
                System Instruction: You are an expert CRM routing agent for a legal services platform named \"Ally Legal Services\". Your task is to analyze an incoming ticket and recommend the best person to handle it. You must return your response in a valid JSON format.

                **CRITICAL INSTRUCTIONS:**
                1.  **Analyze the Ticket:** Read the ticket subject and body to understand the user's need, tone, and urgency.
                2.  **Analyze Personnel:** Review the provided list of personnel and their specializations.
                3.  **Formulate Response:** Create a JSON object with the following keys:
                    -   `summary`: A brief, one-sentence summary of the user's request.
                    -   `priority`: Classify the priority. Must be one of: \"Low\", \"Medium\", \"High\", \"Urgent\".
                    -   `recommendedAssignee`: An object containing the `name` and `role` of the best-suited person from the personnel list.
                    -   `justification`: A concise explanation for why you recommended that person, referencing their specialization and the ticket's content.
                4.  **Do not output any text outside of the JSON object.** Your entire response must be the JSON structure.

                ---
                **Available Personnel & Specializations:**
                ---
                " . json_encode($personnelList, JSON_PRETTY_PRINT) . "
                ---

                ---
                **Incoming Ticket to Analyze:**
                ---
                - **Ticket Type:** {$ticket['type']}
                - **From:** {$ticket['fromName']} ({$ticket['fromEmail']})
                - **Subject:** {$ticket['subject']}
                - **Body:**
                \"" . $ticket['body'] . "\"
                ---

                Generate the JSON analysis for this ticket.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]],
                ['generationConfig' => ['responseMimeType' => "application/json"]]
            );

            $jsonStr = trim($response);
            // Remove markdown fence if present
            $jsonStr = preg_replace('/^```(?:json)?\s*\n?(.*?)\n?\s*```$/s', '$1', $jsonStr);
            $jsonStr = trim($jsonStr);

            return json_decode($jsonStr, true) ?: [
                'summary' => "Failed to analyze the ticket due to an API error.",
                'priority' => 'Medium',
                'recommendedAssignee' => ['name' => 'Dr. Raj Sharma', 'role' => 'Admin'],
                'justification' => "An error occurred during AI analysis. Assigning to Admin for manual review."
            ];

        } catch (Exception $e) {
            log_message('error', "Error analyzing ticket with Gemini API: " . $e->getMessage());
            // Return a default error analysis object
            return [
                'summary' => "Failed to analyze the ticket due to an API error.",
                'priority' => 'Medium',
                'recommendedAssignee' => ['name' => 'Dr. Raj Sharma', 'role' => 'Admin'],
                'justification' => "An error occurred during AI analysis. Assigning to Admin for manual review."
            ];
        }
    }

    /**
     * Gets a WhatsApp chat response.
     * @param WhatsAppMessage[] $conversationHistory
     * @return string
     */
    public function getWhatsAppChatResponse(array $conversationHistory): string
    {
        try {
            $formattedHistory = implode("\n", array_map(fn($m) => "{$m['author']}: {$m['text']}", $conversationHistory));

            $prompt = "
                System Instruction: You are \"Ally\", a friendly and efficient AI assistant for Ally Legal Services, communicating through a website chat widget. Your primary goal is to provide initial assistance.

                **Capabilities:**
                - Answer general questions about services offered (e.g., \"What kind of consulting do you offer?\", \"Can you help with GST registration?\").
                - Understand and categorize user intent (e.g., new lead, service query, grievance).
                - Provide helpful, concise information.

                **Rules:**
                - **Be Conversational:** Use a friendly and professional tone.
                - **Do Not Give Legal Advice:** You are not a lawyer. If a user asks for legal advice, you must state: \"I cannot provide legal advice, but I can connect you with one of our expert consultants who can help.\"
                - **Offer Human Handoff:** If a query is complex, sensitive (e.g., a detailed grievance), or if the user explicitly asks to speak to a person, respond with: \"I can connect you to one of our staff members for further assistance. Would you like me to do that?\"
                - **Keep it Concise:** Provide clear and brief answers.

                ---
                **Conversation History:**
                " . $formattedHistory . "
                ---
                **AI's next response:**
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]]
            );

            return $response;
        } catch (Exception $e) {
            log_message('error', "Error fetching chat response from Gemini API: " . $e->getMessage());
            return "I'm sorry, I'm having trouble connecting right now. Please try again in a moment.";
        }
    }

    /**
     * Runs a security checkup.
     * @param UserSecurityProfile $profile
     * @return array{securityScore: int, recommendations: SecurityRecommendation[]}
     */
    public function runSecurityCheckup(array $profile): array
    {
        try {
            $prompt = "
                System Instruction: You are an expert cybersecurity analyst. Your task is to analyze a user's security profile and provide a security score and actionable recommendations. You must return your response in a valid JSON format.

                **Analysis Factors:**
                - **Password Age:** A password changed over 180 days ago is a risk.
                - **2FA Status:** 2FA not being enabled is a major risk.
                - **Login History:** Look for multiple failed login attempts from the same IP, or successful logins from geographically distant locations in a short time frame (\"impossible travel\").

                **JSON Output Structure:**
                Your entire response MUST be a single JSON object with two keys:
                1.  `securityScore`: An integer between 0 and 100.
                2.  `recommendations`: An array of objects, each with:
                    -   `id`: A unique string for the recommendation (e.g., \"rec-2fa\").
                    -   `text`: A concise, user-friendly recommendation.
                    -   `priority`: \"High\", \"Medium\", or \"Low\".

                **Scoring Logic (Example):**
                - Start at 100.
                - 2FA disabled: -40 points.
                - Password older than 180 days: -20 points.
                - Password older than 365 days: -30 points total.
                - Multiple recent failed logins: -15 points.
                - Evidence of impossible travel: -25 points.

                ---
                **User Security Profile to Analyze:**
                ---
                " . json_encode($profile, JSON_PRETTY_PRINT) . "
                ---

                Generate the JSON analysis for this profile.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]],
                ['generationConfig' => ['responseMimeType' => "application/json"]]
            );

            $jsonStr = trim($response);
            // Remove markdown fence if present
            $jsonStr = preg_replace('/^```(?:json)?\s*\n?(.*?)\n?\s*```$/s', '$1', $jsonStr);
            $jsonStr = trim($jsonStr);

            return json_decode($jsonStr, true) ?: [
                'securityScore' => 0,
                'recommendations' => [['id' => 'rec-error', 'text' => 'Could not perform security check-up due to an API error.', 'priority' => 'High']]
            ];
        } catch (Exception $e) {
            log_message('error', "Error running security checkup with Gemini API: " . $e->getMessage());
            return [
                'securityScore' => 0,
                'recommendations' => [['id' => 'rec-error', 'text' => 'Could not perform security check-up due to an API error.', 'priority' => 'High']]
            ];
        }
    }

    /**
     * Performs legal research.
     * Note: This function would typically require a Google Search API integration,
     * which is not directly part of the Gemini API. A placeholder will be used for sources.
     * @param LegalResearchQuery $researchQuery
     * @return LegalResearchResult
     */
    public function performLegalResearch(array $researchQuery): array
    {
        try {
            $prompt = "
                System Instruction: You are an expert AI Legal Research Assistant for the Indian legal domain. Your task is to conduct thorough research based on the user's query and provide a structured, comprehensive response. Use the provided Google Search results to find relevant case law, statutes, and legal articles.

                **CRITICAL INSTRUCTIONS:**
                1.  **Analyze the Query:** Understand the user's legal question within the specified jurisdiction and research type.
                2.  **Structure the Output:** Format your response using Markdown with the following sections:
                    - ### Research Summary: A concise overview of the findings, directly answering the user's query.
                    - ### Key Case Law: A list of the most relevant court cases. For each case, provide the **case name**, **citation**, **court**, **year**, and a **brief summary** of its relevance to the query.
                    - ### Relevant Statutes & Provisions: A list of applicable laws, sections, or articles. For each, provide the **Act name**, **section number/title**, and a **summary** of the provision.
                    - ### Analysis: A brief analysis connecting the case law and statutes to the user's query.
                3.  **Cite Everything:** It is absolutely essential to base your findings on the provided search results. Your output must be factual and grounded.
                4.  **Do Not Give Legal Advice:** Frame the response as research material, not as legal counsel.
                5.  **Mandatory Disclaimer:** Conclude the entire response with a clear, mandatory disclaimer on a new line, separated by '---'. The disclaimer must state: \"---
**Disclaimer:** This AI-generated research is for informational purposes only and is not a substitute for professional legal advice from a qualified advocate.\"

                ---
                **USER'S RESEARCH QUERY:**
                ---
                - **Query:** \"{$researchQuery['query']}\"
                - **Jurisdiction:** \"{$researchQuery['jurisdiction']}\"
                - **Research Type:** \"{$researchQuery['type']}\"
                ---

                Conduct the research and provide the structured response based on the search results.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]],
                ['tools' => [['googleSearch' => (object)[]]]] // Simulate tool usage config
            );

            $responseText = $response;
            // In a real scenario, grounding chunks would be parsed from the API response.
            // For this pure PHP conversion, we'll simulate empty sources.
            $webSources = [];

            $uniqueSources = []; // Array.from(new Map(webSources.map((item) => [item.uri, item])).values());

            return [
                'summary' => "Research complete.", // This is a placeholder; the main content is in responseText
                'responseText' => $responseText,
                'sources' => $uniqueSources,
            ];

        } catch (Exception $e) {

            print_r($e->getMessage());

            log_message('error', "Error performing legal research with Gemini API: " . $e->getMessage());
            return [
                'summary' => "Error",
                'responseText' => "I'm sorry, but I encountered an error while performing the research. Please check the logs for details and try again later.",
                'sources' => []
            ];
        }
    }

    public function performLegalDrafting(array $draftQuery): array
    {
        try {
            $prompt = "
                System Instruction: You are an expert AI Legal Drafting Assistant for the Indian legal domain. Your task is to draft a professional legal document based on the user's query. Use the details provided by the user to create a structured, formal, and accurate draft.

                **CRITICAL INSTRUCTIONS:**
                1. **Understand the Query:** Identify the type of document, purpose, and relevant facts from the user's input.
                2. **Structure the Output:** Format your response using Markdown with the following sections:
                    - ### Drafted Document: The complete legal draft based on the user's input.
                    - ### Key Clauses: Highlight important clauses and their purpose.
                    - ### Notes: Optional clarifications or instructions for review.
                3. **Do Not Give Legal Advice:** The draft is a template for reference only, not a substitute for professional legal counsel.
                4. **Mandatory Disclaimer:** Conclude the response with a clear disclaimer on a new line, separated by '---'. The disclaimer must state: 
                \"---
    **Disclaimer:** This AI-generated draft is for informational purposes only and is not a substitute for professional legal advice from a qualified advocate.\"

                ---
                **USER'S DRAFT REQUEST:**
                ---
                - **Document Type:** \"{$draftQuery['type']}\"
                - **Purpose/Details:** \"{$draftQuery['query']}\"
                - **Jurisdiction:** \"{$draftQuery['jurisdiction']}\"
                ---
                
                Draft the document in a professional and legally structured format.
            ";

            $response = $this->ai->generateContent(
                "gemini-2.5-flash",
                [['role' => "user", 'parts' => [['text' => $prompt]]]],
                ['tools' => []] // No external tools needed for drafting
            );

            $responseText = $response;

            return [
                'summary' => "Drafting complete.", 
                'responseText' => $responseText,
                'sources' => [] // Not applicable for drafting
            ];

        } catch (Exception $e) {

            print_r($e->getMessage());

            log_message('error', "Error performing legal drafting with Gemini API: " . $e->getMessage());
            return [
                'summary' => "Error",
                'responseText' => "I'm sorry, but I encountered an error while performing the drafting. Please check the logs for details and try again later.",
                'sources' => []
            ];
        }
    }

}